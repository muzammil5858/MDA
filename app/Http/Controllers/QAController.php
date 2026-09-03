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

        $categories = ['Commercial', 'House', 'Plot'];
        $categoryData = [];
        foreach ($categories as $category) {
            $categoryData[$category] = $categoryCounts[$category] ?? 0;
        }

        // ✅ Sectors from sectors table
    $sectorsList = DB::table('sectors')->orderBy('name', 'desc')->get(['id', 'name']);

        // ✅ Blocks from blocks table
        $blocksList = DB::table('blocks')->orderBy('name')->get(['id', 'name', 'sector_id']);

        // Sector-wise category counts
        $sectorCategoryDataRaw = Property::whereIn('sector_id', $sectorsList->pluck('id'))
            ->select('sector_id', 'category')
            ->groupBy('sector_id', 'category')
            ->selectRaw('sector_id, category, COUNT(*) as count')
            ->get()
            ->groupBy('sector_id')
            ->map(function ($rows) use ($categories) {
                $counts = array_fill_keys($categories, 0);
                foreach ($rows as $row) {
                    $key = ucfirst(strtolower($row->category));
                    if (array_key_exists($key, $counts)) {
                        $counts[$key] = $row->count;
                    }
                }
                return $counts;
            });

        $orderedSectorCategoryData = [];
        foreach ($sectorsList as $sector) {
            $orderedSectorCategoryData[$sector->name] = $sectorCategoryDataRaw[$sector->id] ?? array_fill_keys($categories, 0);
        }

        // ✅ Sector -> Block category breakdown
        $rawData = Property::whereIn('sector_id', $sectorsList->pluck('id'))
            ->whereNotNull('block_id')
            ->select('sector_id', 'block_id', 'category')
            ->groupBy('sector_id', 'block_id', 'category')
            ->selectRaw('sector_id, block_id, category, COUNT(*) as count')
            ->get();

        $categoryChartData = [];
        $sectorBlockData   = [];

        foreach ($sectorsList as $sector) {
            $sectorBlocks = $blocksList->where('sector_id', $sector->id);
            $sectorBlockData[$sector->id] = [
                'name'   => $sector->name,
                'blocks' => [],
            ];
            foreach ($sectorBlocks as $block) {
                $label = $sector->name . '|' . $block->name;
                $categoryChartData[$label] = array_fill_keys($categories, 0);
                $sectorBlockData[$sector->id]['blocks'][$block->name] = array_fill_keys($categories, 0);
            }
        }

        foreach ($rawData as $row) {
            $sector = $sectorsList->firstWhere('id', $row->sector_id);
            $block  = $blocksList->firstWhere('id', $row->block_id);
            if (!$sector || !$block) continue;

            $key   = ucfirst(strtolower($row->category));
            $label = $sector->name . '|' . $block->name;

            if (isset($categoryChartData[$label][$key])) {
                $categoryChartData[$label][$key] = $row->count;
            }
            if (isset($sectorBlockData[$sector->id]['blocks'][$block->name][$key])) {
                $sectorBlockData[$sector->id]['blocks'][$block->name][$key] = $row->count;
            }
        }

        // ✅ Sector totals for chart
        $sectorSummary = [];
        foreach ($sectorsList as $sector) {
            $sectorSummary[] = [
                'id'     => $sector->id,
                'name'   => $sector->name,
                'counts' => $orderedSectorCategoryData[$sector->name] ?? array_fill_keys($categories, 0),
            ];
        }

        // ── SECTOR WISE REQUEST STATS (No Town) ──
        $sectorRequestStats = DB::table('requests')
            ->join('sectors', 'requests.sector', '=', 'sectors.name')
            ->selectRaw('
                sectors.id as sector_id,
                sectors.name as sector_name,
                COUNT(requests.id) as total_requests,

                -- Original Allottee (request_type = 1)
                SUM(CASE WHEN request_type = 1 AND dd_action = 1 THEN 1 ELSE 0 END) as original_allottee_completed,
                SUM(CASE WHEN request_type = 1 AND deo_action = 1 AND dd_action IS NULL THEN 1 ELSE 0 END) as original_allottee_inprocess,
                SUM(CASE WHEN request_type = 1 AND deo_action = 0 THEN 1 ELSE 0 END) as original_allottee_rejected,
                SUM(CASE WHEN request_type = 1 AND dd_action IS NULL AND deo_action IS NULL THEN 1 ELSE 0 END) as original_allottee_pending,

                -- Transfer Allottee (request_type = 2 or 3)
                SUM(CASE WHEN request_type IN (2,3) AND dd_action = 1 THEN 1 ELSE 0 END) as transfer_allottee_completed,
                SUM(CASE WHEN request_type IN (2,3) AND deo_action = 1 AND dd_action IS NULL THEN 1 ELSE 0 END) as transfer_allottee_inprocess,
                SUM(CASE WHEN request_type IN (2,3) AND deo_action = 0 THEN 1 ELSE 0 END) as transfer_allottee_rejected,
                SUM(CASE WHEN request_type IN (2,3) AND dd_action IS NULL AND deo_action IS NULL THEN 1 ELSE 0 END) as transfer_allottee_pending
            ')
            ->groupBy('sectors.id', 'sectors.name')
            ->orderBy('sectors.name')
            ->get();

        // ── SECTOR WISE DETAIL (Properties by Sector with Block Data) ──
        $sectorWiseDetails = DB::table('sectors')
            ->leftJoin('properties', 'sectors.id', '=', 'properties.sector_id')
            ->select(
                'sectors.id as sector_id',
                'sectors.name as sector_name',
                DB::raw('COUNT(properties.id) as total_properties'),
                DB::raw('SUM(CASE WHEN properties.category = "Plot" THEN 1 ELSE 0 END) as plot_count'),
                DB::raw('SUM(CASE WHEN properties.category = "House" THEN 1 ELSE 0 END) as house_count'),
                DB::raw('SUM(CASE WHEN properties.category = "Commercial" THEN 1 ELSE 0 END) as commercial_count')
            )
            ->groupBy('sectors.id', 'sectors.name')
            ->orderBy('sectors.name')
            ->get();

        // ── SECTOR WISE BLOCK DETAIL ──
        $sectorBlockWiseDetails = DB::table('sectors')
            ->leftJoin('blocks', 'sectors.id', '=', 'blocks.sector_id')
            ->leftJoin('properties', 'blocks.id', '=', 'properties.block_id')
            ->select(
                'sectors.id as sector_id',
                'sectors.name as sector_name',
                'blocks.id as block_id',
                'blocks.name as block_name',
                DB::raw('COUNT(properties.id) as total_properties'),
                DB::raw('SUM(CASE WHEN properties.category = "Plot" THEN 1 ELSE 0 END) as plot_count'),
                DB::raw('SUM(CASE WHEN properties.category = "House" THEN 1 ELSE 0 END) as house_count'),
                DB::raw('SUM(CASE WHEN properties.category = "Commercial" THEN 1 ELSE 0 END) as commercial_count')
            )
            ->groupBy('sectors.id', 'sectors.name', 'blocks.id', 'blocks.name')
            ->orderBy('sectors.name')
            ->orderBy('blocks.name')
            ->get();

        // ── SECTOR WISE DETAIL GROUPED WITH BLOCK DATA ──
        $sectorWiseDetailsGrouped = $sectorWiseDetails->map(function ($row) use ($sectorBlockWiseDetails) {
            // Get all blocks for this sector
            $blocks = $sectorBlockWiseDetails
                ->where('sector_id', $row->sector_id)
                ->map(function ($block) {
                    return [
                        'block' => $block->block_name,
                        'total_properties' => $block->total_properties ?? 0,
                        'plot_count' => $block->plot_count ?? 0,
                        'house_count' => $block->house_count ?? 0,
                        'commercial_count' => $block->commercial_count ?? 0,
                    ];
                })
                ->values()
                ->toArray();

            // Get block names in order for the data-block-order attribute
            $blockOrder = array_map(function ($block) {
                return $block['block'];
            }, $blocks);

            return [
                'id' => $row->sector_id,
                'name' => $row->sector_name,
                'total_properties' => $row->total_properties ?? 0,
                'plot_count' => $row->plot_count ?? 0,
                'house_count' => $row->house_count ?? 0,
                'commercial_count' => $row->commercial_count ?? 0,
                'block_data' => $blocks,
                'block_order' => $blockOrder,
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

        // Size definitions
        $sizes = [
            '5 Marla' => ['marla', [1, 6]],
            '7 Marla' => ['marla', [6, 8.5]],
            '10 Marla' => ['marla', [8.5, 11]],
            '12 Marla' => ['marla', [11, 13.5]],
            '15 Marla' => ['marla', [13.5, 17.5]],
            '1 Kanal' => ['mixed', [17.5]],
        ];

        // Size-based chart data
        $sizeChartData = [];
        foreach ($sizes as $label => [$column, $range]) {
            $data = [];
            foreach ($sectorsList as $sector) {
                foreach ($blocksList->where('sector_id', $sector->id) as $block) {
                    $data[$sector->name . '|' . $block->name] = 0;
                }
            }

            $query = Property::whereIn('sector_id', $sectorsList->pluck('id'))->whereNotNull('block_id');

            if ($label === '1 Kanal') {
                $query->where(function ($q) use ($range) {
                    $q->where('kanal', 1)->orWhere('marla', '>', $range[0]);
                });
            } else {
                $query->whereBetween('marla', $range);
            }

            $rows = $query->select('sector_id', 'block_id')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('sector_id', 'block_id')
                ->get();

            foreach ($rows as $row) {
                $sector = $sectorsList->firstWhere('id', $row->sector_id);
                $block  = $blocksList->firstWhere('id', $row->block_id);
                if (!$sector || !$block) continue;
                $key = $sector->name . '|' . $block->name;
                if (isset($data[$key])) {
                    $data[$key] = $row->count;
                }
            }
            $sizeChartData[$label] = $data;
        }

        // Stats
        $stats = DB::table('requests')
            ->selectRaw('
                COUNT(id) as total_requests,
                SUM(CASE WHEN dd_action = 1 THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN deo_action = 0 THEN 1 ELSE 0 END) as rejected_count,
                SUM(CASE WHEN deo_action = 1 AND dd_action IS NULL THEN 1 ELSE 0 END) as in_process_count,
                SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND created_at >= DATE_SUB(NOW(), INTERVAL 5 DAY) THEN 1 ELSE 0 END) as pending_new_count,
                SUM(CASE WHEN dd_action IS NULL AND deo_action IS NULL AND created_at < DATE_SUB(NOW(), INTERVAL 5 DAY) THEN 1 ELSE 0 END) as pending_overdue_count
            ')
            ->first();

        // ── TABLES CONFIG ──
        $tables = [
            'new' => [
                'label'      => 'Total REQUEST',
                'sector_total' => 'total_requests',
                'sector_original' => 'original_allottee_pending',
                'sector_transfer'  => 'transfer_allottee_pending',
            ],
            'completed' => [
                'label'      => 'COMPLETED REQUEST',
                'sector_total' => 'total_requests',
                'sector_original' => 'original_allottee_completed',
                'sector_transfer'  => 'transfer_allottee_completed',
            ],
            'inprocess' => [
                'label'      => 'IN PROCESS REQUEST',
                'sector_total' => 'total_requests',
                'sector_original' => 'original_allottee_inprocess',
                'sector_transfer'  => 'transfer_allottee_inprocess',
            ],
            'pending' => [
                'label'      => 'PENDING REQUEST',
                'sector_total' => 'total_requests',
                'sector_original' => 'original_allottee_pending',
                'sector_transfer'  => 'transfer_allottee_pending',
            ],
            'rejected' => [
                'label'      => 'REJECTED REQUEST',
                'sector_total' => 'total_requests',
                'sector_original' => 'original_allottee_rejected',
                'sector_transfer'  => 'transfer_allottee_rejected',
            ],
            'overdue' => [
                'label'      => 'OVERDUE REQUEST',
                'sector_total' => 'total_requests',
                'sector_original' => 'original_allottee_pending',
                'sector_transfer'  => 'transfer_allottee_pending',
            ],
        ];

        // ============================================================
        // NEW CHARTS DATA - Based on property table columns
        // ============================================================

        // 1. Approved Scheme Distribution
        $schemeDistribution = Property::select('approved_scheme', DB::raw('COUNT(*) as count'))
            ->whereNotNull('approved_scheme')
            ->where('approved_scheme', '!=', '')
            ->groupBy('approved_scheme')
            ->pluck('count', 'approved_scheme')
            ->toArray();

        // 2. Allotment Mode Distribution
        $allotmentModeDistribution = Property::select('mode_allottment', DB::raw('COUNT(*) as count'))
            ->whereNotNull('mode_allottment')
            ->where('mode_allottment', '!=', '')
            ->groupBy('mode_allottment')
            ->pluck('count', 'mode_allottment')
            ->toArray();

        // 3. Allotment Type Distribution
        $allotmentTypeDistribution = Property::select('allotment_type', DB::raw('COUNT(*) as count'))
            ->whereNotNull('allotment_type')
            ->where('allotment_type', '!=', '')
            ->groupBy('allotment_type')
            ->pluck('count', 'allotment_type')
            ->toArray();

        // 4. Ownership Type Distribution
        $ownershipTypeDistribution = Property::select('ownership_type', DB::raw('COUNT(*) as count'))
            ->whereNotNull('ownership_type')
            ->where('ownership_type', '!=', '')
            ->groupBy('ownership_type')
            ->pluck('count', 'ownership_type')
            ->toArray();

        // 5. Monthly Allotment Trends (Last 12 months)
        $monthlyAllotments = Property::select(
                DB::raw('DATE_FORMAT(allotment_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('allotment_date')
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->limit(12)
            ->get();

        // 6. Transfer Count Distribution
        $transferDistribution = Property::select('transfer_count', DB::raw('COUNT(*) as count'))
            ->whereNotNull('transfer_count')
            ->groupBy('transfer_count')
            ->orderBy('transfer_count')
            ->get();

        // 7. Category by Allotment Type (for stacked bar)
        $categoryAllotmentType = Property::select('category', 'allotment_type', DB::raw('COUNT(*) as count'))
            ->whereNotNull('category')
            ->whereNotNull('allotment_type')
            ->where('allotment_type', '!=', '')
            ->groupBy('category', 'allotment_type')
            ->get();

        // 8. Sector-wise Approved Schemes
        $sectorSchemes = Property::join('sectors', 'properties.sector_id', '=', 'sectors.id')
            ->select('sectors.name as sector', 'properties.approved_scheme', DB::raw('COUNT(*) as count'))
            ->whereNotNull('properties.approved_scheme')
            ->where('properties.approved_scheme', '!=', '')
            ->groupBy('sectors.name', 'properties.approved_scheme')
            ->get();

        // 9. Category by Ownership Type
        $categoryOwnership = Property::select('category', 'ownership_type', DB::raw('COUNT(*) as count'))
            ->whereNotNull('category')
            ->whereNotNull('ownership_type')
            ->where('ownership_type', '!=', '')
            ->groupBy('category', 'ownership_type')
            ->get();

        // 10. Properties by Mode of Allotment and Category
        $modeCategoryData = Property::select('mode_allottment', 'category', DB::raw('COUNT(*) as count'))
            ->whereNotNull('mode_allottment')
            ->whereNotNull('category')
            ->where('mode_allottment', '!=', '')
            ->groupBy('mode_allottment', 'category')
            ->get();

        return view('qa.dashboard', compact(
            'totalProperties',
            'categoryData',
            'orderedSectorCategoryData',
            'categoryChartData',
            'sizeChartData',
            'categories',
            'sizeCounts',
            'sizes',
            'stats',
            'sectorRequestStats',
            'sectorWiseDetailsGrouped',
            'sectorBlockWiseDetails',
            'sectorSummary',
            'sectorBlockData',
            'tables',
            'sectorsList',
            // New chart data
            'schemeDistribution',
            'allotmentModeDistribution',
            'allotmentTypeDistribution',
            'ownershipTypeDistribution',
            'monthlyAllotments',
            'transferDistribution',
            'categoryAllotmentType',
            'sectorSchemes',
            'categoryOwnership',
            'modeCategoryData'
        ));
    }
    // In QAController.php - Add this method for paginated sector-wise detail

// In QAController.php - getSectorWiseDetails method
public function getSectorWiseDetails(Request $request)
{
    $perPage = $request->get('per_page', 10);
    $page = $request->get('page', 1);
    $search = $request->get('search', '');

    // Get sectors with pagination - EXCLUDE unknown sectors
    $sectorsQuery = DB::table('sectors')
        ->where('name', 'NOT LIKE', '%unknown%')
        ->where('name', 'NOT LIKE', '%Unknown%')
        ->where('name', 'NOT LIKE', '%UNKNOWN%')
        ->orderBy('name')
        ->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        });

    $totalSectors = $sectorsQuery->count();
    $sectors = $sectorsQuery->skip(($page - 1) * $perPage)
        ->take($perPage)
        ->get();

    $sectorIds = $sectors->pluck('id')->toArray();

    if (empty($sectorIds)) {
        return response()->json([
            'data' => [],
            'total' => 0,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => 1,
        ]);
    }

    // Get properties count by sector
    $propertyCounts = DB::table('properties')
        ->select('sector_id', DB::raw('COUNT(*) as total'))
        ->whereIn('sector_id', $sectorIds)
        ->groupBy('sector_id')
        ->pluck('total', 'sector_id');

    // Get category breakdown by sector
    $categoryData = DB::table('properties')
        ->select('sector_id', 'category', DB::raw('COUNT(*) as count'))
        ->whereIn('sector_id', $sectorIds)
        ->groupBy('sector_id', 'category')
        ->get()
        ->groupBy('sector_id');

    // Get block wise details for each sector
    $blockData = DB::table('blocks')
        ->join('properties', 'blocks.id', '=', 'properties.block_id')
        ->select(
            'blocks.sector_id',
            'blocks.name as block_name',
            DB::raw('COUNT(properties.id) as total_properties'),
            DB::raw('SUM(CASE WHEN properties.category = "Plot" THEN 1 ELSE 0 END) as plot_count'),
            DB::raw('SUM(CASE WHEN properties.category = "House" THEN 1 ELSE 0 END) as house_count'),
            DB::raw('SUM(CASE WHEN properties.category = "Commercial" THEN 1 ELSE 0 END) as commercial_count')
        )
        ->whereIn('blocks.sector_id', $sectorIds)
        ->groupBy('blocks.sector_id', 'blocks.name')
        ->get()
        ->groupBy('sector_id');

    // Format the response
    $sectorWiseDetails = [];
    foreach ($sectors as $sector) {
        $sectorId = $sector->id;
        $sectorName = $sector->name;

        $totalProperties = $propertyCounts[$sectorId] ?? 0;

        $plotCount = 0;
        $houseCount = 0;
        $commercialCount = 0;

        if (isset($categoryData[$sectorId])) {
            foreach ($categoryData[$sectorId] as $cat) {
                $category = ucfirst(strtolower($cat->category));
                if ($category === 'Plot') $plotCount = $cat->count;
                elseif ($category === 'House') $houseCount = $cat->count;
                elseif ($category === 'Commercial') $commercialCount = $cat->count;
            }
        }

        $blocks = [];
        $blockOrder = [];

        if (isset($blockData[$sectorId])) {
            foreach ($blockData[$sectorId] as $block) {
                $blocks[] = [
                    'block' => $block->block_name,
                    'total_properties' => $block->total_properties,
                    'plot_count' => $block->plot_count,
                    'house_count' => $block->house_count,
                    'commercial_count' => $block->commercial_count,
                ];
                $blockOrder[] = $block->block_name;
            }
        }

        $sectorWiseDetails[] = [
            'id' => $sectorId,
            'name' => $sectorName,
            'total_properties' => $totalProperties,
            'plot_count' => $plotCount,
            'house_count' => $houseCount,
            'commercial_count' => $commercialCount,
            'block_data' => $blocks,
            'block_order' => $blockOrder,
        ];
    }

    return response()->json([
        'data' => $sectorWiseDetails,
        'total' => $totalSectors,
        'per_page' => $perPage,
        'current_page' => $page,
        'last_page' => ceil($totalSectors / $perPage),
    ]);
}

    public function qaFiles()
    {
        $data = collect();
        return view('qa.filelist', compact("data"));
    }

    public function entryFiles()
    {
        $data = collect();
        return view('qa.filelist1', compact("data"));
    }

    public function excel(Request $request)
    {
        $request->validate([
            'month' => 'required',
        ]);

        $startOfMonth = "{$request->month}-01";
        $startOfMonth = date('Y-m-d', strtotime($startOfMonth));
        $endOfMonth = date('Y-m-d', strtotime("last day of {$request->month}"));

        $users = User::role('deo')->get(['id', 'name']);
        $entries = collect();

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

        $header = ['Date', 'Total Entries'];
        foreach ($users as $user) {
            $header[] = $user->name;
        }

        $rows = [];
        foreach ($data as $date => $entries) {
            $row = [$date, $entries['total']];
            foreach ($users as $user) {
                $row[] = $entries['users'][$user->id] ?? 0;
            }
            $rows[] = $row;
        }

        $xlsx = SimpleXLSXGen::fromArray(array_merge([$header], $rows));
        return $xlsx->download("entries_{$request->month}.xlsx");
    }

    public function propertyArea($id)
    {
        $sector = DB::table('sectors')->orderBy('id')->skip($id)->first();
        $heading = $sector->name ?? 'Unknown Sector';

        $data = DB::table('properties')
            ->select(
                'properties.id',
                'plot_no',
                'sectors.name as sector',
                'sector_id'
            )
            ->leftJoin('sectors', 'sectors.id', '=', 'properties.sector_id')
            ->where('sector_id', $sector->id ?? 0)
            ->orderByRaw('CAST(plot_no AS UNSIGNED) ASC')
            ->get();

        return view('qa.mdhaqalist', compact('data', 'heading'));
    }

    public function propertyList()
    {
        $heading = "Mirpur Development Authority";
        $data = DB::table('properties')
            ->select(
                'properties.id',
                'properties.plot_no',
                'sectors.name as sector',
                'properties.sector_id'
            )
            ->leftJoin('sectors', 'sectors.id', '=', 'properties.sector_id')
            ->get();

        return view('qa.mdhaqalist', compact('data', 'heading'));
    }

    public function scheduleAppointment()
    {
        if (auth()->user()->hasRole('record-clerk')) {
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
                GROUP BY schedules.id, schedules.title, schedules.description, schedules.limit, schedules.start_datetime, schedules.end_datetime, schedules.town
            ", [$user_id]);
        } else {
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
                GROUP BY schedules.id, schedules.title, schedules.description, schedules.limit, schedules.start_datetime, schedules.end_datetime, schedules.town
            ", [$town]);
        }
        $type = DB::table('sectors')->get();
        return view('clerk.appointment', compact('schedules', 'type'));
    }

    public function schedulestore(Request $request)
    {
        $user_id = auth()->user()->id;

        $date = date_create($request->start_datetime);
        $da = date_format($date, "Y-m-d");

        if ($request->town) {
            $check = DB::select("SELECT * FROM schedules WHERE town = '$request->town' AND start_datetime LIKE '$da%'");
            if (!empty($check) && is_null($request['id'])) {
                return redirect()->back()->withErrors(['msg' => 'Already selected for ' . $da]);
            }
        }

        if ($request['start_datetime'] >= $request['end_datetime']) {
            return redirect()->back()->withErrors(['msg' => 'Ending date of board have to be after starting date']);
        }

        $data = $request->validate([
            'user_id' => '',
            'board_id' => '',
            'title' => '',
            'description' => '',
            'type' => '',
            'limit' => '',
            'start_datetime' => '',
            'end_datetime' => '',
        ]);

        if ($request->town) {
            Schedule::updateOrCreate(['id' => $request->id], [
                'user_id' => $user_id,
                'title' => $request['title'],
                'description' => $request['description'],
                'town' => $request['town'],
                'limit' => $request['limit'],
                'start_datetime' => $request['start_datetime'],
                'end_datetime' => $request['end_datetime'],
            ]);
        }

        return redirect()->back()->with('success', 'Appointment Schedule added successfully.');
    }

    public function destroy($id)
    {
        $del = Schedule::where('id', $id)->delete();
        return redirect()->route('schedule.index');
    }

    public function attachements()
    {
        return view('attachement');
    }

    public function testDashboard()
    {
        return view('dashboard2');
    }

    public function ddashboard()
    {
        return view('qa.mdhaqadashboard');
    }

    public function test()
    {
        return view('property.test');
    }

    public function test1()
    {
        return view('property.capture');
    }

    public function connectDevice()
    {
        $command = "C:\Users\Muzamil\Desktop\mdha\app\Lib\ZKFingerSDK\Demo.exe";
        $shell = shell_exec("$command 2>&1");
        return redirect()->back();
    }

    public function DDverify($id, $type)
    {
        if ($type == 1 || $type == 2 || $type == 3 || $type == 4) {
            if ($type == 4) {
                $smallRequest = SmallRequest::with(['property.owners', 'property.township'])->where('request_id', $id)->first();
                $request = Requests::with(['participants.owner', 'participants.representative'])->where('id', $id)->first();
                $property = $smallRequest->property;
                return view('DD.houseConstructionVerification', compact('smallRequest', 'request', 'property', 'type'));
            } else {
                $data = TransferFile::with(['callRepresentative', 'callAttorney'])->where('request_id', $id)->first();
                $property = Property::with([
                    'township',
                    'owners' => function ($query) {
                        $query->where('is_current', 1);
                    },
                ])->where('id', $data->property_id)->first();

                $request = Requests::with(['dummyreceiver', 'dummywitness', 'participants.owner', 'participants.representative', 'dummyreceiver.representative'])->where('id', $id)->first();
                $previous = DB::table('requests')
                    ->where('property_id', $data->property_id)
                    ->where('id', '<', $id)
                    ->whereIn('request_type', [1, 2, 3])
                    ->orderBy('id', 'desc')
                    ->pluck('request_type')
                    ->first();
            }
        }

        switch ($type) {
            case 1:
                return view('property.test', compact('data', 'property', 'request', 'type', 'previous'));
                break;
            case 2:
                return view('DD.warassatVerification', compact('data', 'property', 'request', 'previous'));
                break;
            case 3:
                return view('property.test', compact('data', 'property', 'request', 'type', 'previous'));
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

            $requestRecord->update([
                'clerk_action' => $validated['action'],
                'clerk_remarks' => $validated['remarks'],
                'clerk_action_date' => now(),
                'clerk_id' => auth()->user()->id,
            ]);

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
            $property = Property::with('owners')->findOrFail($propertyId);

            $requests = Requests::where('property_id', $propertyId)
                ->with([
                    'participants' => function ($query) {
                        $query->with('owner');
                    },
                    'transfer',
                    'transferAttaches',
                    'requestGenerationOwner' => function ($query) {
                        $query->with(['owner', 'attachments']);
                    },
                    'witness',
                    'dummywitness'
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            $latestOrder = Requests::where('property_id', $propertyId)
                ->where('request_type', 2)
                ->latest()
                ->first();

            $latestTransfer = Requests::where('property_id', $propertyId)
                ->where('request_type', 1)
                ->latest()
                ->first();

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
