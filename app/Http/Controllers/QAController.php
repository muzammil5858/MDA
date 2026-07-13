<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shuchkin\SimpleXLSXGen;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\Property;
use App\Models\Schedule;
use App\Models\Requests;
use App\Models\TransferFile;
use App\Models\Inheritance;
use App\Models\SmallRequest;
use DB;

class QAController extends Controller
{
public function dashboard()
{
    // Total properties count
    $totalProperties = Property::count();

    // Category counts for all properties
    $categoryCounts = Property::select('category')
        ->groupBy('category')
        ->selectRaw('category, COUNT(*) as count')
        ->pluck('count', 'category')
        ->toArray();

    // Ensure all categories are present, even if count is 0
    $categories = ['Commercial', 'House',  'Plot'];
    $categoryData = [];
    foreach ($categories as $category) {
        $categoryData[$category] = $categoryCounts[$category] ?? 0;
    }

    // Allowed town IDs and their names
    $allowedTownIds = [1, 2, 3, 4, 5];
    $townOrder = [
        1 => 'NST Siakh',
        2 => 'NST Dudyal',
        3 => 'NC Mirpur',
        4 => 'NST Islamgarh',
        5 => 'NST Chaksawari',
    ];

    // Fetch category counts per town
    $townCategoryData = Property::whereIn('town', $allowedTownIds)
        ->select('town', 'category')
        ->groupBy('town', 'category')
        ->selectRaw('town, category, COUNT(*) as count')
        ->get()
        ->groupBy('town')
        ->map(function ($rows) use ($categories) {
            $counts = [];
            foreach ($categories as $category) {
                $counts[$category] = 0;
            }
            foreach ($rows as $row) {
                $categoryKey = ucfirst(strtolower($row->category));
                if (array_key_exists($categoryKey, $counts)) {
                    $counts[$categoryKey] = $row->count;
                }
            }
            return $counts;
        })->toArray();

    // Ensure all towns are present, even if no data
    $orderedTownCategoryData = [];
    foreach ($townOrder as $id => $name) {
        $orderedTownCategoryData[$name] = $townCategoryData[$id] ?? array_fill_keys($categories, 0);
    }

    // Category-based chart data (town|sector with category counts)
    $sectors = ['A', 'B', 'C', 'D', 'E', 'F'];
    $categoryChartData = [];
    foreach ($townOrder as $townId => $townName) {
        foreach ($sectors as $sector) {
            $label = "$townName|$sector";
            $categoryChartData[$label] = array_fill_keys($categories, 0);
        }
    }
    $rawData = Property::whereIn('town', array_keys($townOrder))
        ->whereIn('sector', $sectors)
        ->select('town', 'sector', 'category')
        ->groupBy('town', 'sector', 'category')
        ->selectRaw('town, sector, category, COUNT(*) as count')
        ->get();
    foreach ($rawData as $row) {
        $label = $townOrder[$row->town] . '|' . $row->sector;
        $key = ucfirst(strtolower($row->category));
        if (isset($categoryChartData[$label][$key])) {
            $categoryChartData[$label][$key] = $row->count;
        }
    }

    // Town and sector data with request counts
    $towns = DB::table('towns')
        ->leftJoin('properties', 'towns.id', '=', 'properties.town')
        ->leftJoin('requests as pt_requests', function ($join) {
            $join->on('pt_requests.town', '=', 'towns.id')
                ->on('pt_requests.sector', '=', 'properties.sector')
                ->where('pt_requests.request_type', '=', function ($query) {
                    $query->select('id')->from('request_types')->where('name', 'Property Transfer')->limit(1);
                });
        })
        ->leftJoin('requests as pm_requests', function ($join) {
            $join->on('pm_requests.town', '=', 'towns.id')
                ->on('pm_requests.sector', '=', 'properties.sector')
                ->where('pm_requests.request_type', '=', function ($query) {
                    $query->select('id')->from('request_types')->where('name', 'Property Mapping')->limit(1);
                });
        })
        ->leftJoin('requests as noc_requests', function ($join) {
            $join->on('noc_requests.town', '=', 'towns.id')
                ->on('noc_requests.sector', '=', 'properties.sector')
                ->where('noc_requests.request_type', '=', function ($query) {
                    $query->select('id')->from('request_types')->where('name', 'NOC')->limit(1);
                });
        })
        ->select(
            'towns.id as town_id',
            'towns.name as town_name',
            'properties.sector as sector',
            DB::raw('GROUP_CONCAT(DISTINCT properties.sector ORDER BY properties.sector ASC) as sectors'),
            DB::raw('COUNT(DISTINCT pt_requests.id) as property_transfer_count'),
            DB::raw('COUNT(DISTINCT pm_requests.id) as property_mapping_count'),
            DB::raw('COUNT(DISTINCT noc_requests.id) as noc_count')
        )
        ->groupBy('towns.id', 'towns.name', 'properties.sector')
        ->get();

    // Transform the data to group sectors under each town
    $townsGrouped = $towns->groupBy('town_id')->map(function ($townGroup) {
        $sectors = $townGroup->map(function ($row) {
            return [
                'sector' => $row->sector,
                'property_transfer_count' => $row->property_transfer_count,
                'property_mapping_count' => $row->property_mapping_count,
                'noc_count' => $row->noc_count,
            ];
        })->filter(function ($row) {
            return !is_null($row['sector']);
        })->values();

        return [
            'id' => $townGroup->first()->town_id,
            'name' => $townGroup->first()->town_name,
            'sectors' => $sectors->isNotEmpty() ? $sectors->pluck('sector')->unique()->implode(',') : '',
            'sector_data' => $sectors,
            'property_transfer_count' => $townGroup->sum('property_transfer_count'),
            'property_mapping_count' => $townGroup->sum('property_mapping_count'),
            'noc_count' => $townGroup->sum('noc_count'),
        ];
    })->values();


    $townWiseDetails = DB::table('towns')
    ->leftJoin('properties', 'towns.id', '=', 'properties.town')
    ->select(
        'towns.id as town_id',
        'towns.name as town_name',
        'properties.sector as sector',
        DB::raw('GROUP_CONCAT(DISTINCT properties.sector ORDER BY properties.sector ASC) as sectors'),
        DB::raw('COUNT(properties.id) as total_properties'),
        DB::raw('SUM(CASE WHEN properties.category = "Plot" THEN 1 ELSE 0 END) as plot_count'),
        DB::raw('SUM(CASE WHEN properties.category = "House" THEN 1 ELSE 0 END) as house_count'),
        DB::raw('SUM(CASE WHEN properties.category = "Commercial" THEN 1 ELSE 0 END) as commercial_count'),

        // ✅ Add these lines:
        DB::raw("COUNT(CASE WHEN properties.transfer_count IS NULL THEN 1 END) as original_allottee"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count = 1 THEN 1 END) as first_transfer"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count = 2 THEN 1 END) as second_transfer"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count = 3 THEN 1 END) as third_transfer"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count = 4 THEN 1 END) as fourth_transfer"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count >= 5 THEN 1 END) as fifth_transfer")
    )
    ->groupBy('towns.id', 'towns.name', 'properties.sector')
    ->get();

    // dd($townWiseDetails);

// Transform the data to group sectors under each town
$townWiseDetailsGrouped = $townWiseDetails->groupBy('town_id')->map(function ($townGroup) {
    $sectors = $townGroup->map(function ($row) {
        return [
            'sector' => $row->sector,
            'total_properties' => $row->total_properties,
            'plot_count' => $row->plot_count,
            'house_count' => $row->house_count,
            'commercial_count' => $row->commercial_count,
            'original_allottee' => $row->original_allottee ?? 0,
            'first_transfer' => $row->first_transfer ?? 0,
            'second_transfer' => $row->second_transfer ?? 0,
            'third_transfer' => $row->third_transfer ?? 0,
            'fourth_transfer' => $row->fourth_transfer ?? 0,
            'fifth_transfer' => $row->fifth_transfer ?? 0,
        ];
    })->filter(function ($row) {
        return !is_null($row['sector']);
    })->values();

    return [
        'id' => $townGroup->first()->town_id,
        'name' => $townGroup->first()->town_name,
        'sectors' => $sectors->isNotEmpty() ? $sectors->pluck('sector')->unique()->implode(',') : '',
        'sector_data' => $sectors,
        'total_properties' => $townGroup->sum('total_properties'),
        'plot_count' => $townGroup->sum('plot_count'),
        'house_count' => $townGroup->sum('house_count'),
        'commercial_count' => $townGroup->sum('commercial_count'),
    ];
})->values();

 // Size counts for properties
$sizeCounts = [
    '5 Marla' => DB::table('properties')->whereBetween('marla', [1, 6])->count(),
    '7 Marla' => DB::table('properties')->whereBetween('marla', [6, 8.5])->count(),
    '10 Marla' => DB::table('properties')->whereBetween('marla', [8.5, 11])->count(),
    '12 Marla' => DB::table('properties')->whereBetween('marla', [11, 13.5])->count(),
    '15 Marla' => DB::table('properties')->whereBetween('marla', [13.5, 17.5])->count(),
    '1 Kanal' => DB::table('properties')->where(function ($query) {
        $query->where('kanal', 1)->orWhere('marla', '>', 17.5);
    })->count(),
];

// Size-based chart data (town|sector with size counts)
$sizes = [
    '5 Marla' => ['marla', [1, 6]],
    '7 Marla' => ['marla', [6, 8.5]],
    '10 Marla' => ['marla', [8.5, 11]],
    '12 Marla' => ['marla', [11, 13.5]],
    '15 Marla' => ['marla', [13.5, 17.5]],
    '1 Kanal' => ['mixed', [17.5]], // 'mixed' indicates using both kanal and marla
];

$sizeChartData = [];
foreach ($sizes as $label => [$column, $range]) {
    $data = [];
    foreach ($townOrder as $townId => $townName) {
        foreach ($sectors as $sector) {
            $key = "$townName|$sector";
            $data[$key] = 0;
        }
    }

    $query = Property::whereIn('town', array_keys($townOrder))
        ->whereIn('sector', $sectors);

    if ($label === '1 Kanal') {
        $query->where(function ($query) use ($range) {
            $query->where('kanal', 1)->orWhere('marla', '>', $range[0]);
        });
    } else {
        $query->whereBetween('marla', $range);
    }

    $rawData = $query
        ->select('town', 'sector')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('town', 'sector')
        ->get();

    foreach ($rawData as $row) {
        $townName = $townOrder[$row->town] ?? null;
        if ($townName) {
            $key = "$townName|{$row->sector}";
            $data[$key] = $row->count;
        }
    }
    $sizeChartData[$label] = $data;
}
   $dataReviewSummary = DB::select("
    SELECT
        users.id AS user_id,
        users.name AS clerk_name,
        SUM(CASE WHEN properties.status IS NOT NULL AND properties.status != '' THEN 1 ELSE 0 END) AS review_entries,
        SUM(CASE WHEN properties.status = 'Document Missing' THEN 1 ELSE 0 END) AS document_missing,
        SUM(CASE WHEN properties.status = 'Blur Document' THEN 1 ELSE 0 END) AS blur_document,
        SUM(CASE WHEN properties.status = 'Wrong Attachement' THEN 1 ELSE 0 END) AS wrong_attachment,
        SUM(CASE WHEN properties.status = 'Wrong Center' THEN 1 ELSE 0 END) AS wrong_entry,
        SUM(CASE WHEN properties.status = 'No Error' THEN 1 ELSE 0 END) AS no_error,
        SUM(CASE WHEN properties.resolved = 1 THEN 1 ELSE 0 END) AS resolved
    FROM
        properties
    JOIN
        users ON users.id = properties.qa_id
    GROUP BY
        users.id, users.name
");
$allotmentStages = DB::table('properties')
    ->selectRaw("
        COUNT(CASE WHEN transfer_count IS NULL THEN 1 END) as original_allottee,
        COUNT(CASE WHEN transfer_count = 1 THEN 1 END) as first_transfer,
        COUNT(CASE WHEN transfer_count = 2 THEN 1 END) as second_transfer,
        COUNT(CASE WHEN transfer_count = 3 THEN 1 END) as third_transfer,
        COUNT(CASE WHEN transfer_count = 4 THEN 1 END) as fourth_transfer,
        COUNT(CASE WHEN transfer_count >= 5 THEN 1 END) as fifth_transfer
    ")
    ->first();

$townStageCounts = DB::table('properties')
    ->join('towns', 'properties.town', '=', 'towns.id')
    ->select(
        'towns.id as town_id',
        'towns.name as town_name',
        DB::raw("COUNT(CASE WHEN properties.transfer_count IS NULL THEN 1 END) as original_allottee"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count = 1 THEN 1 END) as first_transfer"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count = 2 THEN 1 END) as second_transfer"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count = 3 THEN 1 END) as third_transfer"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count = 4 THEN 1 END) as fourth_transfer"),
        DB::raw("COUNT(CASE WHEN properties.transfer_count >= 5 THEN 1 END) as fifth_transfer")
    )
    ->groupBy('towns.id', 'towns.name')
    ->orderBy('towns.name')
    ->get();

   $stats = DB::table('requests')
    ->selectRaw('
        COUNT(id) as total_requests,

        SUM(CASE WHEN dd_action = 1 THEN 1 ELSE 0 END) as completed_count,
        SUM(CASE WHEN deo_action = 0 THEN 1 ELSE 0 END) as rejected_count,

        SUM(CASE
            WHEN deo_action = 1
             AND dd_action IS NULL
            THEN 1 ELSE 0
        END) as in_process_count,

        SUM(CASE
            WHEN dd_action IS NULL
             AND deo_action IS NULL
             AND created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY)
            THEN 1 ELSE 0
        END) as pending_new_count,

        SUM(CASE
            WHEN dd_action IS NULL
             AND deo_action IS NULL
             AND created_at < DATE_SUB(NOW(), INTERVAL 5 DAY)
            THEN 1 ELSE 0
        END) as pending_overdue_count
    ')
    ->first();


   $townStats = DB::table('requests')
        ->join('towns', 'requests.town', '=', 'towns.id')
        ->selectRaw('
            towns.id   as town_id,
            towns.name as town_name,
           COUNT(requests.id) as total_requests,
        SUM(CASE WHEN request_type = 1 THEN 1 ELSE 0 END) as total_transfer,
        SUM(CASE WHEN request_type = 2 THEN 1 ELSE 0 END) as total_warassat,
        SUM(CASE WHEN request_type = 3 THEN 1 ELSE 0 END) as total_hibba,
            SUM(CASE WHEN dd_action = 1 THEN 1 ELSE 0 END) as completed_total,
            SUM(CASE WHEN dd_action = 1 AND request_type = 1 THEN 1 ELSE 0 END) as completed_transfer,
            SUM(CASE WHEN dd_action = 1 AND request_type = 2 THEN 1 ELSE 0 END) as completed_warassat,
            SUM(CASE WHEN dd_action = 1 AND request_type = 3 THEN 1 ELSE 0 END) as completed_hibba,
            SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL THEN 1 ELSE 0 END) as inprocess_total,
            SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL AND request_type = 1 THEN 1 ELSE 0 END) as inprocess_transfer,
            SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL AND request_type = 2 THEN 1 ELSE 0 END) as inprocess_warassat,
            SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL AND request_type = 3 THEN 1 ELSE 0 END) as inprocess_hibba,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) THEN 1 ELSE 0 END) as pending_total,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 1 THEN 1 ELSE 0 END) as pending_transfer,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 2 THEN 1 ELSE 0 END) as pending_warassat,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 3 THEN 1 ELSE 0 END) as pending_hibba,
            SUM(CASE WHEN deo_action = 0 THEN 1 ELSE 0 END) as rejected_total,
            SUM(CASE WHEN deo_action = 0 AND request_type = 1 THEN 1 ELSE 0 END) as rejected_transfer,
            SUM(CASE WHEN deo_action = 0 AND request_type = 2 THEN 1 ELSE 0 END) as rejected_warassat,
            SUM(CASE WHEN deo_action = 0 AND request_type = 3 THEN 1 ELSE 0 END) as rejected_hibba,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) THEN 1 ELSE 0 END) as overdue_total,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 1 THEN 1 ELSE 0 END) as overdue_transfer,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 2 THEN 1 ELSE 0 END) as overdue_warassat,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 3 THEN 1 ELSE 0 END) as overdue_hibba
        ')
        ->groupBy('towns.id', 'towns.name')
        ->orderBy('towns.name')
        ->get();

    $sectorStats = DB::table('requests')
        ->join('towns', 'requests.town', '=', 'towns.id')
        ->selectRaw('
            towns.id as town_id,
            requests.sector as sector_name,
                  COUNT(requests.id) as total_requests,
        SUM(CASE WHEN request_type = 1 THEN 1 ELSE 0 END) as total_transfer,
        SUM(CASE WHEN request_type = 2 THEN 1 ELSE 0 END) as total_warassat,
        SUM(CASE WHEN request_type = 3 THEN 1 ELSE 0 END) as total_hibba,
            SUM(CASE WHEN dd_action = 1 THEN 1 ELSE 0 END) as completed_total,
            SUM(CASE WHEN dd_action = 1 AND request_type = 1 THEN 1 ELSE 0 END) as completed_transfer,
            SUM(CASE WHEN dd_action = 1 AND request_type = 2 THEN 1 ELSE 0 END) as completed_warassat,
            SUM(CASE WHEN dd_action = 1 AND request_type = 3 THEN 1 ELSE 0 END) as completed_hibba,
            SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL THEN 1 ELSE 0 END) as inprocess_total,
            SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL AND request_type = 1 THEN 1 ELSE 0 END) as inprocess_transfer,
            SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL AND request_type = 2 THEN 1 ELSE 0 END) as inprocess_warassat,
            SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL AND request_type = 3 THEN 1 ELSE 0 END) as inprocess_hibba,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) THEN 1 ELSE 0 END) as pending_total,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 1 THEN 1 ELSE 0 END) as pending_transfer,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 2 THEN 1 ELSE 0 END) as pending_warassat,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 3 THEN 1 ELSE 0 END) as pending_hibba,
            SUM(CASE WHEN deo_action = 0 THEN 1 ELSE 0 END) as rejected_total,
            SUM(CASE WHEN deo_action = 0 AND request_type = 1 THEN 1 ELSE 0 END) as rejected_transfer,
            SUM(CASE WHEN deo_action = 0 AND request_type = 2 THEN 1 ELSE 0 END) as rejected_warassat,
            SUM(CASE WHEN deo_action = 0 AND request_type = 3 THEN 1 ELSE 0 END) as rejected_hibba,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) THEN 1 ELSE 0 END) as overdue_total,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 1 THEN 1 ELSE 0 END) as overdue_transfer,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 2 THEN 1 ELSE 0 END) as overdue_warassat,
            SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND requests.created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) AND request_type = 3 THEN 1 ELSE 0 END) as overdue_hibba
        ')
        ->groupBy('towns.id', 'requests.sector') // Don't forget to group by the sector here as well if you haven't!
        ->orderBy('towns.id')
        ->orderBy('requests.sector')
        ->get()->groupBy('town_id'); ;

    // Return view with all data
    return view('qa.dashboard', compact(
        'totalProperties',
        'categoryData',
        'orderedTownCategoryData',
        'categoryChartData', // Renamed for category chart
        'sizeChartData',    // Renamed for size chart
        'categories',
        'towns',
        'townsGrouped',
        'sizeCounts',
        'sizes',
        'dataReviewSummary' ,
        'townsGrouped' ,
        'townWiseDetailsGrouped',
        'allotmentStages' ,
        'townStageCounts',
        'stats',
        'townStats',
        'sectorStats'
    ));
}
    public function qaFiles(){
        $data = DB::table('properties')
        ->select('id', 'code', 'plot_no', 'category', 'created_at')
        ->whereNull('deo')
        ->whereNull('de_date')
        ->get();

        return view('qa.filelist',compact("data"));

    }
    public function entryFiles(){
        $data = DB::table('properties')
    ->leftJoin('users', 'users.id', '=', 'properties.deo')
    ->leftJoin('attchements', 'attchements.property_id', '=', 'properties.id')
    ->select(
        'properties.id',
        'code',
        'plot_no',
        'category',
        'de_date',
        'name',
        DB::raw("
            CASE
                WHEN attchements.order_attach is not null THEN 1
                WHEN attchements.affected_house is not null THEN 1
                WHEN attchements.builtup_property is not null THEN 1
                WHEN attchements.entitlement is not null THEN 1
                WHEN attchements.allot_com is not null THEN 1
                WHEN attchements.allot_order is not null THEN 1
                WHEN attchements.chit_mapping is not null THEN 1
                ELSE 0
            END AS attachement
        ")
    )
    ->whereNotNull('properties.deo')
    ->whereNotNull('properties.de_date')
    ->orderBy('attachement', 'desc')
    ->get();

        return view('qa.filelist1',compact("data"));

    }

    public function excel(Request $request){

        $request->validate([
            'month' => 'required',
        ]);
        $startOfMonth = "{$request->month}-01";

        // Convert to Y-m-d format
        $startOfMonth = date('Y-m-d', strtotime($startOfMonth));

        // Get the last day of the month and format it to Y-m-d
        $endOfMonth = date('Y-m-d', strtotime("last day of {$request->month}"));

        // Fetch users
        $users = User::role('deo')->get(['id', 'name']);


        // Fetch entries using a custom query
        $entries = DB::table('properties')
            ->selectRaw('de_date, deo, COUNT(id) as entry_count')
            ->whereBetween(DB::raw("STR_TO_DATE(de_date, '%d-%m-%Y')"), [$startOfMonth, $endOfMonth])
            ->groupBy('de_date', 'deo')
            ->get();

        $data = [];
        foreach ($entries as $entry) {
            $date = $entry->de_date;

            if (!isset($data[$date])) {
                $data[$date] = [
                    'total' => 0,
                    'users' => [],
                ];
            }

            $data[$date]['total'] += $entry->entry_count;
            $data[$date]['users'][$entry->deo] = $entry->entry_count;
        }


        // Prepare header row with dynamic user columns
        $header = ['Date', 'Total Entries'];
        foreach ($users as $user) {
            $header[] = $user->name; // Add user columns to header
        }

        // Prepare data rows
        $rows = [];
        foreach ($data as $date => $entries) {
            $row = [$date, $entries['total']]; // Add Date and Total Entries

            // Add user-specific entry counts
            foreach ($users as $user) {
                $row[] = $entries['users'][$user->id] ?? 0; // Default to 0 if no entries for the user
            }

            $rows[] = $row;
        }

        // Generate the Excel file
        $xlsx = SimpleXLSXGen::fromArray(array_merge([$header], $rows));

        // Download the file
        return $xlsx->download("entries_{$request->month}.xlsx");

    }


    public function propertyArea($id){
        $areas = ['New Small Town Siakh','New Small Town Dudyal','New City Mirpur','New Small Town Islamgarh','New Small Town Chaksawari'];
        $heading = $areas[$id];
        $id = $id+1;
        $data = DB::table('properties')
    ->select(
        'properties.id',
        'code',
        'plot_no',
        'center',
        'towns.name as town',
        'sector'
    )
    ->leftJoin('towns', 'towns.id', '=', 'properties.town')
    ->where('town', $id)
    ->orderByRaw('CAST(plot_no AS UNSIGNED) ASC')
    ->get();

    return view('qa.mdhaqalist',compact('data','heading'));
    }
    public function propertyList(){

        $heading = "Mangla Dam Housing Authority";
      $data = DB::table('properties')
    ->select(
        'properties.id',
        'properties.code',
        'properties.plot_no',
        'properties.center',
        'towns.name as town', // 👈 get town name from joined table
        'properties.sector'
    )
    ->leftJoin('towns', 'towns.id', '=', 'properties.town')
    ->get();

    return view('qa.mdhaqalist',compact('data','heading'));
    }

    public function scheduleAppointment(){
       if(auth()->user()->hasRole('record-clerk')){
        $user_id = auth()->user()->id;
        $schedules = DB::select("
                            SELECT
                                schedules.id,
                                schedules.title,
                                schedules.description,
                                schedules.town,
                                schedules.limit,
                                schedules.start_datetime,
                                schedules.end_datetime,
                                GROUP_CONCAT(users.name SEPARATOR ', ') as booked_users
                            FROM schedules
                            LEFT JOIN appointment ON schedules.id = appointment.schedule_id
                            LEFT JOIN users ON users.id = appointment.user_id
                            WHERE schedules.user_id = ?
                            GROUP BY schedules.id,schedules.title,schedules.description,schedules.limit,schedules.start_datetime,schedules.end_datetime,schedules.town
                        ", [$user_id]);



        }else{
            $town = auth()->user()->town;
            $schedules = DB::select("
                            SELECT
                                schedules.id,
                                schedules.title,
                                schedules.description,
                                schedules.town,
                                schedules.limit,
                                schedules.start_datetime,
                                schedules.end_datetime,
                                GROUP_CONCAT(users.name SEPARATOR ', ') as booked_users
                            FROM schedules
                            LEFT JOIN appointment ON schedules.id = appointment.schedule_id
                            LEFT JOIN users ON users.id = appointment.user_id
                            WHERE schedules.town = ?
                            GROUP BY schedules.id,schedules.title,schedules.description,schedules.limit,schedules.start_datetime,schedules.end_datetime,schedules.town
                        ", [$town]);
        }
        $type = DB::table('towns')->get();
        return view('clerk.appointment',compact('schedules','type'));

    }
    public function schedulestore(Request $request)
    {
        $user_id = auth()->user()->id;



       $date = date_create($request->start_datetime);
       $da = date_format($date,"Y-m-d");

        if($request->town){

                  $check = DB::select("SELECT * FROM schedules where  town = '$request->town' and start_datetime like '$da%'");

               if(!empty($check) && is_null($request['id'])){
                return redirect()->back()->withErrors(['msg' => $ty.' Already selected for '.$da]);
               }


        }

         if($request['start_datetime'] >= $request['end_datetime']){
                return redirect()->back()->withErrors(['msg' => 'Ending date of board have to be after starting date']);
               }


            $data = $request->validate([
                'user_id' => '',
                'board_id'=> '',
                'title' => '',
               'description'=> '',
                'type'=> '',
                'limit'=> '',
                'start_datetime'=> '',
               'end_datetime'=> '',


            ]);
             if($request->town){


            $newdata = Schedule::updateOrCreate(['id' => $request->id], [

                'user_id'=>$user_id,

                'title' => $request['title'],
                'description'=> $request['description'],
                'town'=> $request['town'],
                'limit'=> $request['limit'],
                'start_datetime'=> $request['start_datetime'],
                'end_datetime'=> $request['end_datetime'],



            ]);

    }

            return redirect()->back()->with('success','Appointment Schdule added successfully.');

        }

        public function destroy($id)
    {

        $del = Schedule::where('id',$id)->delete();

        return redirect()->route('schedule.index');

    }

    public function attachements(){
        return view('attachement');
    }
    public function testDashboard(){

        return view('dashboard2');
    }
    public function ddashboard(){
        return view('qa.mdhaqadashboard');
    }

    public function test(){
        return view('property.test');
    }
    public function test1(){
        return view('property.capture');
    }

    public function connectDevice(){
        // dd('ggg');
        $command = "C:\Users\Muzamil\Desktop\mdha\app\Lib\ZKFingerSDK\Demo.exe";
//     // "$exePath 2>&1"
//     $output = exec("$command 2>&1",$output, $status);
//  var_dump(file_put_contents('php://stderr', print_r($output, true)));
// file_put_contents('php://stderr', "Status: $status\n");

    $shell = shell_exec("$command 2>&1");
    return redirect()->back();

    }
     public function DDverify($id,$type){
        if($type == 1  || $type == 2 || $type == 3 || $type == 4){
            if($type == 4){
                // For Type 4 (House Construction), get data from small_requests table
                $smallRequest = SmallRequest::with(['property.owners', 'property.township'])->where('request_id', $id)->first();
                $request = Requests::with(['participants.owner', 'participants.representative'])->where('id', $id)->first();
                $property = $smallRequest->property;

                return view('DD.houseConstructionVerification', compact('smallRequest', 'request', 'property', 'type'));
            } else {
                $data = TransferFile::with(['callRepresentative','callAttorney'])->where('request_id',$id)->first();


                $property = Property::with([
    'township',
    'owners' => function ($query) {
        $query->where('is_current', 1);
    },
    ])->where('id', $data->property_id)->first();

                $request = Requests::with(['dummyreceiver','dummywitness','participants.owner','participants.representative','dummyreceiver.representative'])->where('id',$id)->first();
                $previous = DB::table('requests')
                ->where('property_id', $data->property_id)
                ->where('id', '<', $id)
                ->whereIn('request_type',[1,2,3])
                ->orderBy('id', 'desc')
                ->pluck('request_type')
                ->first();

            }
        }

        switch ($type) {
    case 1:
        return view('property.test',compact('data','property','request','type','previous'));
        break;

    case 2:
        return view('DD.warassatVerification',compact('data','property','request','previous'));
        break;
    case 3:
        return view('property.test',compact('data','property','request','type','previous'));
        break;
    }

    }
    public function houseConstructionAction(Request $request)
    {
        try {
            $validated = $request->validate([
                'action' => 'required|in:approve,reject,forward',
                'remarks' => 'required|string|max:1000',
                'request_id' => 'required|exists:requests,id',
                'request_type' => 'required|in:4'
            ]);

            $requestRecord = Requests::find($validated['request_id']);

            // Update request with clerk action
            $requestRecord->update([
                'clerk_action' => $validated['action'],
                'clerk_remarks' => $validated['remarks'],
                'clerk_action_date' => now(),
                'clerk_id' => auth()->user()->id,
            ]);

            // If forwarding to DD, we might need additional logic
            if ($validated['action'] === 'forward') {
                // Additional logic for forwarding to DD can be added here
                // For now, just mark as forwarded
            }

            return response()->json([
                'success' => true,
                'message' => 'Action completed successfully.'
            ]);

        } catch (\Exception $e) {
            \Log::error('House Construction Action Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing action: ' . $e->getMessage()
            ], 500);
        }
    }
    public function history($propertyId)
{
    try {
        // Fetch property with owner relationships
        $property = Property::with('owners')
            ->findOrFail($propertyId);

        // Fetch all requests related to this property with necessary relationships
        $requests = Requests::where('property_id', $propertyId)
            ->with([
                'participants' => function($query) {
                    $query->with('owner');
                },
                'transfer',
                'transferAttaches',
                'requestGenerationOwner' => function($query) {
                    $query->with(['owner', 'attachments']);
                },
                'witness',
                'dummywitness'
            ])
            ->orderBy('created_at', 'desc')
            ->get();


        // Fetch latest transfer and order data
        $latestOrder = Requests::where('property_id', $propertyId)
            ->where('request_type', 2) // Assuming 2 = Order type
            ->latest()
            ->first();

        $latestTransfer = Requests::where('property_id', $propertyId)
            ->where('request_type', 1) // Assuming 1 = Transfer type
            ->latest()
            ->first();

        // Convert to collections if null
        $latestOrder = collect($latestOrder ? [$latestOrder] : []);
        $latestTransfer = collect($latestTransfer ? [$latestTransfer] : []);

        return view('history', [
            'property' => $property,
            'requests' => $requests,
            'latestOrder' => $latestOrder,
            'latestTransfer' => $latestTransfer,
            'id' => $propertyId
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        dd($e->getMessage());
        return redirect()->route('properties.index')
            ->with('error', 'Property not found');
    } catch (\Exception $e) {
        dd($e->getMessage());
        \Log::error('History view error: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Error loading transaction history');
    }
}



}
