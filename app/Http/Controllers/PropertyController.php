<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Payment;
use App\Models\Block;
use App\Models\Sector;
use App\Models\PlotHistory;
use App\Models\Attchement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
        public function getBlocks($sectorId)
{
    // If sector is 'all' or empty, return empty collection
    if (empty($sectorId) || $sectorId === '') {
        return response()->json([]);
    }

    // Find blocks that belong to this sector
    $blocks = Block::where('sector_id', $sectorId)->orderBy('name')->get();

    return response()->json($blocks);
}
    /**
     * Show the multi-step form (create).
     */
    public function create()
    {
        $property = null;
        $sectors = Sector::orderBy('name')->get();


        return view('property.form', compact('property', 'sectors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Step 1
            'application_no'        => 'required|string',
            'application_date'      => 'nullable|date',
            'plot_no'               => 'required|string',
            'sector_id' => 'nullable|exists:sectors,id',
            'block_id'              => 'nullable|exists:blocks,id',
            'kanal'                 => 'nullable|numeric',
            'marla'                 => 'nullable|numeric',
            'sqrft'                 => 'nullable|numeric',
            'approved_scheme'       => 'nullable|string',
            'size'                  => 'nullable|string|max:255',
            'form_no'               => 'nullable|string|max:255',
            'remarks'               => 'nullable|string',
            'initial_draft_amount'  => 'nullable|numeric',
            'initial_draft_date'    => 'nullable|date',
            'applicant_name'        => 'nullable|string',
            'father_husband_name'   => 'nullable|string',
            'old_nic'               => 'nullable|string',
            'cnic'                  => 'nullable|string',
            'address_temporary'     => 'nullable|string',
            'address_permanent'     => 'nullable|string',
            'category'              => 'nullable|string',
            'mode_allottment'       => 'nullable|string',
            'allotment_date'        => 'nullable|date',
            'balloting_serial_no'   => 'nullable|string',
        'transfer_count'        => 'nullable|integer|min:0',
        'ownership_type'        => 'nullable|in:single,multiple',
        'allotment_type'        => 'nullable|in:original,transferee',

            // Step 2
            'total_price'             => 'nullable|numeric',
            'amount_deposited'       => 'nullable|numeric',
            'remaining_amount'       => 'nullable|numeric',
            'down_payment'           => 'nullable|numeric',
            'initial_notice_no'      => 'nullable|string',
            'initial_notice_date'    => 'nullable|date',
            'total_received_amount'  => 'nullable|numeric',
            'received_amount_date'   => 'nullable|date',
            'allotment_order_no'     => 'nullable|string',
            'allotment_order_date'   => 'nullable|date',
            'possession_slip_no'     => 'nullable|string',
            'possession_slip_date'   => 'nullable|date',
            'boundary_wall_approval' => 'nullable|string',
            'map_approval_date'      => 'nullable|date',
            'transfer_order_no'      => 'nullable|string',

            // Step 3
            'transferees'               => 'nullable|array',
            'transferees.*.name'       => 'nullable|string',
            'transferees.*.father_name'=> 'nullable|string',
            'transferees.*.id_card'    => 'nullable|string',
            'transferees.*.challan_no' => 'nullable|string',

            // Step 4
            'alternate_allotment'          => 'nullable|string',
            'complete_property_file'       => 'required|file',
            'adjacent_area_allotment'      => 'nullable|file',
            'division_of_plots'            => 'nullable|file',
            'decision_courts'              => 'nullable|file',
            'decision_allotment_committee' => 'nullable|file',
            'decision_mda_board'           => 'nullable|file',
            'decision_revising_authority'  => 'nullable|file',
        ], [
            'application_no.unique' => 'This Application No. already exists. Please use a different number.',
            'application_no.required' => 'The Application No. is required.',
        ]);

        DB::beginTransaction();

        try {
            // 1) Property
            $property = Property::create([
                'application_no'       => $request->application_no,
                'application_date'     => $request->application_date,
                'plot_no'              => $request->plot_no,
                'sector_id'             => $request->sector_id,
                'block_id'                  => $request->block_id,
                'kanal'                => $request->kanal,
                'marla'                => $request->marla,
                'sqrft'                => $request->sqrft,
                'approved_scheme'      => $request->approved_scheme,
                'size'                 => $request->size,
                'form_no'              => $request->form_no,
                'remarks'              => $request->remarks,
                'initial_draft_amount' => $request->initial_draft_amount,
                'initial_draft_date'   => $request->initial_draft_date,
                'applicant_name'       => $request->applicant_name,
                'father_husband_name'  => $request->father_husband_name,
                'old_nic'              => $request->old_nic,
                'cnic'                 => $request->cnic,
                'address_temporary'    => $request->address_temporary,
                'address_permanent'    => $request->address_permanent,
                'category'             => $request->category,
                'mode_allottment'      => $request->mode_allottment,
                'allotment_date'       => $request->allotment_date,
                'balloting_serial_no'  => $request->balloting_serial_no,
                'user_id'              => auth()->id(),
                'transfer_count'       => $request->transfer_count,
                'ownership_type'       => $request->ownership_type,
                'allotment_type'       => $request->allotment_type,
            ]);

            // 2) Payment
            Payment::create([
                'property_id'             => $property->id,
                'total_price'             => $request->total_price,
                'amount_deposited'        => $request->amount_deposited,
                'remaining_amount'        => $request->remaining_amount,
                'down_payment'            => $request->down_payment,
                'initial_notice_no'       => $request->initial_notice_no,
                'initial_notice_date'     => $request->initial_notice_date,
                'total_received_amount'   => $request->total_received_amount,
                'received_amount_date'    => $request->received_amount_date,
                'allotment_order_no'      => $request->allotment_order_no,
                'allotment_order_date'    => $request->allotment_order_date,
                'possession_slip_no'      => $request->possession_slip_no,
                'possession_slip_date'    => $request->possession_slip_date,
                'boundary_wall_approval'  => $request->boundary_wall_approval,
                'map_approval_date'       => $request->map_approval_date,
                'transfer_order_no'       => $request->transfer_order_no,
            ]);

            // 3) Plot History (transferees)
            if ($request->has('transferees')) {
                foreach ($request->transferees as $row) {
                    if (empty($row['name']) && empty($row['father_name']) && empty($row['id_card']) && empty($row['challan_no'])) {
                        continue;
                    }
                    PlotHistory::create([
                        'property_id' => $property->id,
                        'name'        => $row['name'] ?? null,
                        'father_name' => $row['father_name'] ?? null,
                        'id_card'     => $row['id_card'] ?? null,
                        'challan_no'  => $row['challan_no'] ?? null,
                    ]);
                }
            }

            // 4) Attachment (files)
            $attachmentData = [
                'property_id'         => $property->id,
                'alternate_allotment' => $request->alternate_allotment,
                'complete_file_pages' =>$request->complete_file_pages,
                'status'              => false, // Default status
                'entry_date'          => null,
            ];

            $this->storeAttachmentFiles($request, $property, $attachmentData);
            Attchement::create($attachmentData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message'  => 'Property, payment, plot history and attachments saved successfully.',
                'redirect' => route('formList'),
            ]);
        }

        return redirect()->route('formList')->with('success', 'Property, payment, plot history and attachments saved successfully.');
    }

    /**
 * List of all submitted properties (with related data).
 */
/**
 * List of all submitted properties (with related data).
 */
/**
 * List of properties with missing complete_property_file.
 */
// public function formList()
// {
//     $data = Property::with(['properties','payment', 'plotHistories', 'attachment', 'sector', 'block'])
//         ->whereDoesntHave('properties', function($query) {
//             $query->whereNotNull('user_id');
//         })
//         ->orWhereHas('properties', function($query) {
//             $query->whereNull('user_id');
//         })
//         ->latest()
//         ->get();

//     return view('property.formlist', compact('data'));
// }
public function formList()
{
    $data = Property::with(['payment', 'plotHistories', 'attachment', 'sector', 'block'])
        ->whereNull('user_id')  // Only properties without a user
        ->latest()
        ->get();

    return view('property.formlist', compact('data'));
}

/**
 * List of properties created by the logged-in user.
 */
public function entriesList()
{
    $data = Property::with(['payment', 'plotHistories', 'attachment', 'sector', 'block'])
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('property.Entries_List', compact('data'));
}

    // /**
    //  * List of all submitted properties (with related data).
    //  */
    // public function formList()
    // {
    //     $data = Property::with(['payment', 'plotHistories', 'attachment','sector','block'])->latest()->get();
    //     return view('property.formlist', compact('data'));
    // }

    /**
     * Show a single property's full detail.
     */
    public function formDetail($id)
    {
        $property = Property::with(['payment', 'plotHistories', 'attachment' , 'sector','block'])->findOrFail($id);
        return view('property.formDetail', compact('property'));
    }

    /**
     * Edit form for an existing property.
     */
    public function formEdit($id)
    {
        $property = Property::with(['payment', 'plotHistories', 'attachment','sector' , 'block'])->findOrFail($id);
        $sectors = Sector::orderBy('name')->get();
           // Get blocks for the selected sector
    $blocks = collect(); // Empty collection by default
    if ($property->sector_id) {

            $blocks = Block::where('sector_id', $property->sector->id)->orderBy('name')->get();

    }


        return view('property.form-edit', compact('property', 'id', 'sectors','blocks'));
    }

    /**
     * Update an existing property record (all 4 tables).
     */
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        // Validation
        $request->validate([
            'application_no'        => 'required|string',
            'application_date'      => 'nullable|date',
            'plot_no'               => 'required|string',
            'sector_id'             => 'nullable|exists:sectors,id',
            'block_id'              => 'nullable|exists:blocks,id',
            'kanal'                 => 'nullable|numeric',
            'marla'                 => 'nullable|numeric',
            'sqrft'                 => 'nullable|numeric',
            'approved_scheme'       => 'nullable|string',
            'size'                  => 'nullable|string|max:255',
            'form_no'               => 'nullable|string|max:255',
            'remarks'               => 'nullable|string',
            'initial_draft_amount'  => 'nullable|numeric',
            'initial_draft_date'    => 'nullable|date',
            'applicant_name'        => 'nullable|string',
            'father_husband_name'   => 'nullable|string',
            'old_nic'               => 'nullable|string',
            'cnic'                  => 'nullable|string',
            'address_temporary'     => 'nullable|string',
            'address_permanent'     => 'nullable|string',
            'category'              => 'nullable|string',
            'mode_allottment'       => 'nullable|string',
            'allotment_date'        => 'nullable|date',
            'balloting_serial_no'   => 'nullable|string',
                    'transfer_count'        => 'nullable|integer|min:0',
        'ownership_type'        => 'nullable|in:single,multiple',
        'allotment_type'        => 'nullable|in:original,transferee',
            'total_price'           => 'nullable|numeric',
            'amount_deposited'      => 'nullable|numeric',
            'remaining_amount'      => 'nullable|numeric',
            'down_payment'          => 'nullable|numeric',
            'initial_notice_no'     => 'nullable|string',
            'initial_notice_date'   => 'nullable|date',
            'total_received_amount' => 'nullable|numeric',
            'received_amount_date'  => 'nullable|date',
            'allotment_order_no'    => 'nullable|string',
            'allotment_order_date'  => 'nullable|date',
            'possession_slip_no'    => 'nullable|string',
            'possession_slip_date'  => 'nullable|date',
            'boundary_wall_approval'=> 'nullable|string',
            'map_approval_date'     => 'nullable|date',
            'transfer_order_no'     => 'nullable|string',
            'transferees'           => 'nullable|array',
            'transferees.*.name'    => 'nullable|string',
            'transferees.*.father_name' => 'nullable|string',
            'transferees.*.id_card' => 'nullable|string',
            'transferees.*.challan_no' => 'nullable|string',
            'alternate_allotment'   => 'nullable|string',
            'complete_file_pages'   =>'required|integer',
            'complete_property_file' => 'nullable|file',
            'adjacent_area_allotment' => 'nullable|file',
            'division_of_plots'     => 'nullable|file',
            'decision_courts'       => 'nullable|file',
            'decision_allotment_committee' => 'nullable|file',
            'decision_mda_board'    => 'nullable|file',
            'decision_revising_authority' => 'nullable|file',
        ], [
            'application_no.unique' => 'This Application No already exists. Please use a different number.',
            'application_no.required' => 'The Application No is required.',
        ]);

        DB::beginTransaction();

        try {
            $oldApplicationNo = $property->application_no;
            $newApplicationNo = $request->application_no;

    $confirmChecked = $request->has('check_complete_file') && $request->check_complete_file == '1';

    $userId = $confirmChecked ? auth()->id() : $property->user_id;


            // 1) Update Property
            $property->update([
                'application_no'       => $newApplicationNo,
                'application_date'     => $request->application_date,
                'plot_no'              => $request->plot_no,
                'sector_id' => $request->sector_id,
                'block_id'                => $request->block_id,
                'kanal'                => $request->kanal,
                'marla'                => $request->marla,
                'sqrft'                => $request->sqrft,
                'approved_scheme'      => $request->approved_scheme,
                'size'                 => $request->size,
                'form_no'              => $request->form_no,
                'remarks'              => $request->remarks,
                'initial_draft_amount' => $request->initial_draft_amount,
                'initial_draft_date'   => $request->initial_draft_date,
                'applicant_name'       => $request->applicant_name,
                'father_husband_name'  => $request->father_husband_name,
                'old_nic'              => $request->old_nic,
                'cnic'                 => $request->cnic,
                'address_temporary'    => $request->address_temporary,
                'address_permanent'    => $request->address_permanent,
                'category'             => $request->category,
                'mode_allottment'      => $request->mode_allottment,
                'allotment_date'       => $request->allotment_date,
                'balloting_serial_no'  => $request->balloting_serial_no,
                    'transfer_count'       => $request->transfer_count,
    'ownership_type'       => $request->ownership_type,
    'allotment_type'       => $request->allotment_type,
                 'user_id'              => $userId,
            ]);

            // 2) Update Payment
            Payment::updateOrCreate(
                ['property_id' => $property->id],
                [
                    'total_price'             => $request->total_price,
                    'amount_deposited'        => $request->amount_deposited,
                    'remaining_amount'        => $request->remaining_amount,
                    'down_payment'            => $request->down_payment,
                    'initial_notice_no'       => $request->initial_notice_no,
                    'initial_notice_date'     => $request->initial_notice_date,
                    'total_received_amount'   => $request->total_received_amount,
                    'received_amount_date'    => $request->received_amount_date,
                    'allotment_order_no'      => $request->allotment_order_no,
                    'allotment_order_date'    => $request->allotment_order_date,
                    'possession_slip_no'      => $request->possession_slip_no,
                    'possession_slip_date'    => $request->possession_slip_date,
                    'boundary_wall_approval'  => $request->boundary_wall_approval,
                    'map_approval_date'       => $request->map_approval_date,
                    'transfer_order_no'       => $request->transfer_order_no,
                ]
            );

            // 3) Update Plot History
            if ($request->has('transferees')) {
                PlotHistory::where('property_id', $property->id)->delete();

                foreach ($request->transferees as $row) {
                    if (empty($row['name']) && empty($row['father_name']) && empty($row['id_card']) && empty($row['challan_no'])) {
                        continue;
                    }
                    PlotHistory::create([
                        'property_id' => $property->id,
                        'name'        => $row['name'] ?? null,
                        'father_name' => $row['father_name'] ?? null,
                        'id_card'     => $row['id_card'] ?? null,
                        'challan_no'  => $row['challan_no'] ?? null,
                    ]);
                }
            }

            // 4) Rename folder if application_no changed
           if ($oldApplicationNo && $oldApplicationNo !== $newApplicationNo) {
    $this->renameAttachmentFolder(
        $oldApplicationNo,
        $newApplicationNo,
        $property->id
    );
}
            // 5) Update Attachments
    $attachmentData = [
        'alternate_allotment' => $request->alternate_allotment,
         'complete_file_pages' => $request->complete_file_pages,

        ];
    $this->storeAttachmentFiles($request, $property, $attachmentData);

    $attachment = Attchement::where('property_id', $property->id)->first();
    $hasFile = $request->hasFile('complete_property_file') ||
               ($attachment && !empty($attachment->complete_property_file));

    // Sirf checkbox check hone par hi status/entry_date confirm hoga
    if ($confirmChecked && $attachment && !$attachment->status && $hasFile) {
        $attachmentData['status']     = true;
        $attachmentData['entry_date'] = now();
    }
    // Checkbox uncheck ho to status/entry_date ko touch nahi karenge (as-is rahenge)

    if ($attachment) {
        $attachment->update($attachmentData);
    } else {
        $attachmentData['property_id'] = $property->id;
        Attchement::create($attachmentData);
    }

    DB::commit();

            // ✅ JSON Response for AJAX
            if ($request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Property updated successfully.',
                    'redirect' => route('formList'),
                ]);
            }

            return redirect()->route('formList')->with('success', 'Property updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }








    public function formDelete($id)
    {
        Property::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Entry deleted successfully.');
    }

    private function sanitizeFolderName(?string $name, int $fallbackId): string
    {
        $folderName = preg_replace('/[^A-Za-z0-9_\-]/', '_', trim((string) $name));
        $folderName = trim($folderName, '_');

        return $folderName !== '' ? $folderName : ('property_' . $fallbackId);
    }

    private function storeAttachmentFiles(Request $request, Property $property, array &$attachmentData)
    {
        $fileFieldLabels = [
            'complete_property_file'       => 'Complete Property File',
            'adjacent_area_allotment'      => 'Adjacent Area Allotment',
            'division_of_plots'            => 'Division of Plots',
            'decision_courts'              => 'Decision of Courts Against Plot',
            'decision_allotment_committee' => 'Decision of Allotment Committee',
            'decision_mda_board'           => 'Decision of MDA Board',
            'decision_revising_authority'  => 'Decision of Revising Authority',
        ];

        $applicationFolder = $this->sanitizeFolderName($property->application_no, $property->id);
        $disk = \Illuminate\Support\Facades\Storage::disk('public');

        foreach ($fileFieldLabels as $field => $label) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);

                $labelFolder = $this->sanitizeFolderName($label, 0);
                $folderPath  = $applicationFolder . '/' . $labelFolder;

                $originalName     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeOriginalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $extension        = $file->getClientOriginalExtension();

                $fileName = $safeOriginalName . '.' . $extension;

                if ($disk->exists($folderPath . '/' . $fileName)) {
                    $fileName = $safeOriginalName . '_' . uniqid() . '_' . time() . '.' . $extension;
                }

                $path = $file->storeAs($folderPath, $fileName, 'public');
                $attachmentData[$field] = $path;
            }
        }
    }

 private function renameAttachmentFolder(
    string $oldApplicationNo,
    string $newApplicationNo,
    int $propertyId
) {
    $disk = \Illuminate\Support\Facades\Storage::disk('public');

    $oldFolder = $this->sanitizeFolderName($oldApplicationNo, $propertyId);
    $newFolder = $this->sanitizeFolderName($newApplicationNo, $propertyId);

    if ($oldFolder === $newFolder || !$disk->exists($oldFolder)) {
        return;
    }

    $files = $disk->allFiles($oldFolder);

    foreach ($files as $filePath) {
        $newPath = str_replace(
            $oldFolder . '/',
            $newFolder . '/',
            $filePath
        );

        $disk->makeDirectory(dirname($newPath));
        $disk->move($filePath, $newPath);
    }

    // Attachment directly by property_id
    $attachment = Attchement::where('property_id', $propertyId)->first();

    if ($attachment) {
        $fields = [
            'complete_property_file',
            'adjacent_area_allotment',
            'division_of_plots',
            'decision_courts',
            'decision_allotment_committee',
            'decision_mda_board',
            'decision_revising_authority',
        ];

        foreach ($fields as $field) {
            if (!empty($attachment->$field)) {
                $attachment->$field = str_replace(
                    $oldFolder . '/',
                    $newFolder . '/',
                    $attachment->$field
                );
            }
        }

        $attachment->save();
    }
}



/**
 * Dashboard view - shows summary cards (total properties etc.)
 */
public function dashboard()
{
    $totalProperties  = Property::count();
    $totalPayments    = Payment::count();
    $totalPlotHistory = PlotHistory::count();
    $totalAttachments = Attchement::count();

    // Sector-wise grouped properties (for the expandable list)
    $propertiesBySector = Property::with('sector')
        ->orderBy('sector_id')
        ->get()
        ->groupBy(function ($property) {
            return $property->sector->name ?? 'No Sector Assigned';
        });

            $propertiesByBlock = Property::with('block')
        ->orderBy('block_id')
        ->get()
        ->groupBy(function ($property) {
            return $property->block->name ?? 'No block Assigned';
        });

            // NEW: User-wise grouped properties
    $propertiesByUser = Property::with('user')
        ->orderBy('user_id')
        ->get()
        ->groupBy(function ($property) {
            return $property->user->name ?? 'Unknown User';
        });

    return view('property.dashboard', compact(
        'totalProperties',
        'totalPayments',
        'totalPlotHistory',
        'totalAttachments',
        'propertiesBySector',
        'propertiesByBlock',
         'propertiesByUser'
    ));
}





}
