<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Payment;
use App\Models\Block;
use App\Models\Sector;
use App\Models\PlotHistory;
use App\Models\CurrentOwner;
use App\Models\Attchement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function getBlocks($sectorId)
    {
        if (empty($sectorId) || $sectorId === '') {
            return response()->json([]);
        }

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
            'sector_id'             => 'required|exists:sectors,id',
            'block_id'              => 'required|exists:blocks,id',
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
            'transferees.*.address'    => 'nullable|string',
            'transferees.*.allottee_date' => 'nullable|date',

            // Current Owners
            'current_owners' => 'nullable|array',
            'current_owners.*.applicant_name' => 'nullable|string|max:255',
            'current_owners.*.father_husband_name' => 'nullable|string|max:255',
            'current_owners.*.old_nic' => 'nullable|string|max:50',
            'current_owners.*.cnic' => 'nullable|string|max:15',
            'current_owners.*.address_temporary' => 'nullable|string',
            'current_owners.*.address_permanent' => 'nullable|string',

            // Step 4
            'alternate_allotment'          => 'nullable|string',
            'property_document'            => 'required|file',
            'adjacent_area_allotment'      => 'nullable|file',
            'allotment_order'              => 'nullable|file',
            'decision_courts'              => 'nullable|file',
            'decision_allotment_committee' => 'nullable|file',
            'decision_mda_board'           => 'nullable|file',
            'decision_revising_authority'  => 'nullable|file',
            'noting_file'                  => 'nullable|file',
            'cnic_front'                   => 'nullable|file',
        ]);

        DB::beginTransaction();
        $sector = Sector::findOrFail($request->sector_id);
        $block = Block::findOrFail($request->block_id);

        try {
            // 1) Property
            $property = Property::create([
                'application_no'       => $request->application_no,
                'application_date'     => $request->application_date,
                'plot_no'              => $request->plot_no,
                'sector_id'            => $request->sector_id,
                'block_id'             => $request->block_id,
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

            // 2) Save Current Owners
            if ($request->has('current_owners')) {
                foreach ($request->current_owners as $ownerData) {
                    if (empty($ownerData['applicant_name']) &&
                        empty($ownerData['father_husband_name']) &&
                        empty($ownerData['cnic']) &&
                        empty($ownerData['old_nic'])) {
                        continue;
                    }

                    $ownerData['property_id'] = $property->id;
                    CurrentOwner::create($ownerData);
                }
            }

            // 3) Payment
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

            // 4) Plot History (transferees)
            if ($request->has('transferees')) {
                foreach ($request->transferees as $row) {
                    if (empty($row['name']) && empty($row['father_name']) && empty($row['id_card']) && empty($row['challan_no']) &&
                        empty($row['address']) && empty($row['allottee_date'])) {
                        continue;
                    }
                    PlotHistory::create([
                        'property_id' => $property->id,
                        'name'        => $row['name'] ?? null,
                        'father_name' => $row['father_name'] ?? null,
                        'id_card'     => $row['id_card'] ?? null,
                        'challan_no'  => $row['challan_no'] ?? null,
                        'address'       => $row['address'] ?? null,
                        'allottee_date' => $row['allottee_date'] ?? null,
                    ]);
                }
            }

            // 5) Attachment (files)
            $attachmentData = [
                'property_id'         => $property->id,
                'alternate_allotment' => $request->alternate_allotment,
                'property_document' => $request->property_document ?? null,
                'status'              => false,
                'entry_date'          => null,
            ];

            $this->storeAttachmentFiles($request, $property, $attachmentData,
            $sector->name, $block->name );
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
                'message'  => 'Property, current owners, payment, plot history and attachments saved successfully.',
                'redirect' => route('formList'),
            ]);
        }

        return redirect()->route('formList')->with('success', 'Property, current owners, payment, plot history and attachments saved successfully.');
    }

    /**
     * List of all submitted properties (with related data).
     */
    public function formList()
    {
        $data = Property::with(['payment', 'plotHistories', 'attachment', 'sector', 'block'])
            ->whereNull('user_id')
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

    /**
     * Show a single property's full detail.
     */
    public function formDetail($id)
    {
        $property = Property::with(['payment', 'plotHistories', 'attachment', 'sector', 'block'])
            ->findOrFail($id);
        return view('property.formDetail', compact('property'));
    }

    /**
     * Edit form for an existing property.
     */
    public function formEdit($id)
    {
        $property = Property::with(['payment', 'plotHistories', 'attachment', 'sector', 'block'])
            ->findOrFail($id);
        $sectors = Sector::orderBy('name')->get();
        $blocks = collect();

        if ($property->sector_id) {
            $blocks = Block::where('sector_id', $property->sector_id)->orderBy('name')->get();
        }

        return view('property.form-edit', compact('property', 'id', 'sectors', 'blocks'));
    }

    /**
     * Update an existing property record (all tables).
     */
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        // 🔥 Check if property_document already exists in database
        $existingAttachment = Attchement::where('property_id', $property->id)->first();
        $hasExistingDocument = $existingAttachment && !empty($existingAttachment->property_document);

        // 🔥 Remove empty file fields from request
        $fileFields = ['property_document', 'adjacent_area_allotment', 'allotment_order',
                       'decision_courts', 'decision_allotment_committee', 'decision_mda_board',
                       'decision_revising_authority', 'noting_file', 'cnic_front'];

        foreach ($fileFields as $field) {
            if ($request->has($field) && empty($request->$field)) {
                $request->request->remove($field);
            }
        }

        // 🔥 Dynamic validation rule for property_document
        $propertyDocumentRule = $hasExistingDocument ? 'nullable|file' : 'required|file';

        $request->validate([
            'application_no'        => 'required|string',
            'application_date'      => 'nullable|date',
            'plot_no'               => 'required|string',
            'sector_id'             => 'required|exists:sectors,id',
            'block_id'              => 'required|exists:blocks,id',
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
            'current_owners' => 'nullable|array',
            'current_owners.*.applicant_name' => 'nullable|string|max:255',
            'current_owners.*.father_husband_name' => 'nullable|string|max:255',
            'current_owners.*.old_nic' => 'nullable|string|max:50',
            'current_owners.*.cnic' => 'nullable|string|max:15',
            'current_owners.*.address_temporary' => 'nullable|string',
            'current_owners.*.address_permanent' => 'nullable|string',
            'alternate_allotment'   => 'nullable|string',
            'complete_file_pages'   => 'nullable|integer',
            'property_document'     => $propertyDocumentRule,
            'adjacent_area_allotment' => 'nullable|file',
            'allotment_order'     => 'nullable|file',
            'decision_courts'       => 'nullable|file',
            'decision_allotment_committee' => 'nullable|file',
            'decision_mda_board'    => 'nullable|file',
            'decision_revising_authority' => 'nullable|file',
            'transferees.*.address'    => 'nullable|string',
            'transferees.*.allottee_date' => 'nullable|date',
            'noting_file'                  => 'nullable|file',
            'cnic_front'                   => 'nullable|file',
        ]);

        DB::beginTransaction();

        try {
            $oldApplicationNo = $property->application_no;
            $newApplicationNo = $request->application_no;

            // 🔥 Store old sector/block for path change detection
            $oldSectorId = $property->sector_id;
            $oldBlockId = $property->block_id;
            $oldPlotNo = $property->plot_no;

            $confirmChecked = $request->has('check_complete_file') && $request->check_complete_file == '1';
            $userId = $confirmChecked ? auth()->id() : $property->user_id;

            // 1) Update Property
            $property->update([
                'application_no'       => $newApplicationNo,
                'application_date'     => $request->application_date,
                'plot_no'              => $request->plot_no,
                'sector_id'            => $request->sector_id,
                'block_id'             => $request->block_id,
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

            // 2) Save Current Owners
            if ($request->has('current_owners')) {
                CurrentOwner::where('property_id', $property->id)->delete();

                foreach ($request->current_owners as $ownerData) {
                    if (empty($ownerData['applicant_name']) &&
                        empty($ownerData['father_husband_name']) &&
                        empty($ownerData['cnic']) &&
                        empty($ownerData['old_nic'])) {
                        continue;
                    }

                    $ownerData['property_id'] = $property->id;
                    CurrentOwner::create($ownerData);
                }
            }

            // 3) Update Payment
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

            // 4) Update Plot History
            if ($request->has('transferees')) {
                PlotHistory::where('property_id', $property->id)->delete();

                foreach ($request->transferees as $row) {
                    if (empty($row['name']) && empty($row['father_name']) && empty($row['id_card']) && empty($row['challan_no'])&&
                        empty($row['address']) && empty($row['allottee_date'])) {
                        continue;
                    }
                    PlotHistory::create([
                        'property_id' => $property->id,
                        'name'        => $row['name'] ?? null,
                        'father_name' => $row['father_name'] ?? null,
                        'id_card'     => $row['id_card'] ?? null,
                        'challan_no'  => $row['challan_no'] ?? null,
                        'address'     => $row['address'] ?? null,
                        'allottee_date' => $row['allottee_date'] ?? null,
                    ]);
                }
            }

            // 🔥 Check what changed
            $sectorChanged = $oldSectorId != $request->sector_id;
            $blockChanged = $oldBlockId != $request->block_id;
            $plotNoChanged = $oldPlotNo != $request->plot_no;
            $appNoChanged = $oldApplicationNo !== $newApplicationNo;

            // 🔥 UPDATE ATTACHMENT PATHS IF ANYTHING CHANGED
            if ($sectorChanged || $blockChanged || $plotNoChanged || $appNoChanged) {
                $property->refresh();
                $property->load(['sector', 'block']);

                $this->renameAttachmentFolder(
                    $property,
                    $oldApplicationNo,
                    $newApplicationNo,
                    true // Force update
                );
            }

            // 6) Update Attachments
            $attachmentData = [
                'alternate_allotment' => $request->alternate_allotment,
                'complete_file_pages' => $request->complete_file_pages,
            ];

            $this->storeAttachmentFiles($request, $property, $attachmentData);

            $attachment = Attchement::where('property_id', $property->id)->first();
            $hasFile = $request->hasFile('property_document') ||
                       ($attachment && !empty($attachment->property_document));

            if ($confirmChecked && $attachment && !$attachment->status && $hasFile) {
                $attachmentData['status']     = true;
                $attachmentData['entry_date'] = now();
            }

            if ($attachment) {
                $attachment->update($attachmentData);
            } else {
                $attachmentData['property_id'] = $property->id;
                Attchement::create($attachmentData);
            }

            DB::commit();

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

    private function sanitizeFolderName(?string $name, int $fallbackId = 0): string
    {
        $folderName = preg_replace('/[^A-Za-z0-9_\-]/', '_', trim((string) $name));
        $folderName = trim($folderName, '_');

        return $folderName !== '' ? $folderName : ('item_' . $fallbackId);
    }

    private function storeAttachmentFiles(
        Request $request,
        Property $property,
        array &$attachmentData,
        ?string $sectorName = null,
        ?string $blockName = null
    ) {
        $fileFieldLabels = [
            'property_document'            => 'Property Document',
            'adjacent_area_allotment'      => 'Adjacent Area Allotment',
            'allotment_order'              => 'Allotment Order',
            'decision_courts'              => 'Decision of Courts Against Plot',
            'decision_allotment_committee' => 'Decision of Allotment Committee',
            'decision_mda_board'           => 'Decision of MDA Board',
            'decision_revising_authority'  => 'Decision of Revising Authority',
            'noting_file'                  => 'Noting File',
            'cnic_front'                   => 'CNIC Front',
        ];

        // Get sector and block names if not provided
        if (!$sectorName && $property->sector) {
            $sectorName = $property->sector->name;
        }
        if (!$blockName && $property->block) {
            $blockName = $property->block->name;
        }

        // Sanitize folder names
        $sectorFolder = $this->sanitizeFolderName($sectorName ?? 'No_Sector');
        $blockFolder = $this->sanitizeFolderName($blockName ?? 'No_Block');
        $applicationFolder = $this->sanitizeFolderName($property->application_no, $property->id);

        // Create folder structure: Sector/Block/ApplicationNo
        $baseFolder = $sectorFolder . '/' . $blockFolder . '/' . $applicationFolder;

        $disk = Storage::disk('public');

        // Get existing attachment record
        $existingAttachment = Attchement::where('property_id', $property->id)->first();

        foreach ($fileFieldLabels as $field => $label) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);

                $labelFolder = $this->sanitizeFolderName($label);
                $folderPath  = $baseFolder . '/' . $labelFolder;

                // 🔥 Use application_no instead of plot_no
                $applicationNo = $property->application_no ?? 'APP';
                $sectorNameForFile = $this->sanitizeFolderName($sectorName ?? 'SECTOR');

                // 🔥 File name: APP-123_AZIZPUR
                $fileName = 'APP-' . $applicationNo . '_' . $sectorNameForFile;
                $extension = $file->getClientOriginalExtension();
                $fileName = $fileName . '.' . $extension;

                if ($disk->exists($folderPath . '/' . $fileName)) {
                    $fileName = 'APP-' . $applicationNo . '_' . $sectorNameForFile . '_' . uniqid() . '.' . $extension;
                }

                if ($existingAttachment && !empty($existingAttachment->$field)) {
                    $oldFilePath = $existingAttachment->$field;
                    if ($disk->exists($oldFilePath)) {
                        $disk->delete($oldFilePath);
                    }
                }

                $path = $file->storeAs($folderPath, $fileName, 'public');
                $attachmentData[$field] = $path;
            } else {
                if ($existingAttachment && !empty($existingAttachment->$field)) {
                    $attachmentData[$field] = $existingAttachment->$field;
                }
            }
        }
    }

    /**
     * 🔥 RENAME/UPDATE ATTACHMENT PATHS
     * This method checks if old files exist and updates their paths
     * based on current sector/block/application_no
     */
    private function renameAttachmentFolder(
        Property $property,
        string $oldApplicationNo,
        string $newApplicationNo,
        bool $forceUpdate = false
    ) {
        $disk = Storage::disk('public');

        $attachment = Attchement::where('property_id', $property->id)->first();

        if (!$attachment) {
            return;
        }

        // Get new folder structure
        $sectorName = $property->sector->name ?? 'No_Sector';
        $blockName = $property->block->name ?? 'No_Block';

        $sectorFolder = $this->sanitizeFolderName($sectorName);
        $blockFolder = $this->sanitizeFolderName($blockName);
        $applicationFolder = $this->sanitizeFolderName($newApplicationNo, $property->id);

        $newBaseFolder = $sectorFolder . '/' . $blockFolder . '/' . $applicationFolder;

        // Get old folder structure using original values
        $oldSectorFolder = $this->sanitizeFolderName($property->getOriginal('sector_id') ?
            Sector::find($property->getOriginal('sector_id'))->name ?? 'No_Sector' : 'No_Sector');
        $oldBlockFolder = $this->sanitizeFolderName($property->getOriginal('block_id') ?
            Block::find($property->getOriginal('block_id'))->name ?? 'No_Block' : 'No_Block');
        $oldApplicationFolder = $this->sanitizeFolderName($oldApplicationNo, $property->id);

        $oldBaseFolder = $oldSectorFolder . '/' . $oldBlockFolder . '/' . $oldApplicationFolder;

        // If folder structure is same and not force update, return
        if ($oldBaseFolder === $newBaseFolder && !$forceUpdate) {
            return;
        }

        // Fields to update
        $fields = [
            'property_document',
            'adjacent_area_allotment',
            'allotment_order',
            'decision_courts',
            'decision_allotment_committee',
            'decision_mda_board',
            'decision_revising_authority',
            'noting_file',
            'cnic_front',
        ];

        $updated = false;

        foreach ($fields as $field) {
            if (empty($attachment->$field)) {
                continue;
            }

            $oldPath = $attachment->$field;
            $fileName = basename($oldPath);

            // 🔥 CHECK: If file name starts with "APP-"
            if (strpos($fileName, 'APP-') === 0) {
                // Generate new file name using current application_no and sector
                $applicationNo = $property->application_no ?? 'APP';
                $sectorNameForFile = $this->sanitizeFolderName($sectorName);

                // New file name: APP-123_AZIZPUR
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = 'APP-' . $applicationNo . '_' . $sectorNameForFile . '.' . $extension;

                // Get field label folder
                $labelFolder = $this->sanitizeFolderName(
                    str_replace('_', ' ', ucwords(str_replace('_', ' ', $field)))
                );

                $newPath = $newBaseFolder . '/' . $labelFolder . '/' . $newFileName;

                // If file exists, add unique identifier
                if ($disk->exists($newPath)) {
                    $newFileName = 'APP-' . $applicationNo . '_' . $sectorNameForFile . '_' . uniqid() . '.' . $extension;
                    $newPath = $newBaseFolder . '/' . $labelFolder . '/' . $newFileName;
                }

                // 🔥 MOVE FILE TO NEW LOCATION
                if ($disk->exists($oldPath)) {
                    // Ensure directory exists
                    $disk->makeDirectory(dirname($newPath));

                    // Move file
                    $disk->move($oldPath, $newPath);

                    // Update database path
                    $attachment->$field = $newPath;
                    $updated = true;
                }
            } else if ($forceUpdate) {
                // 🔥 If file name doesn't start with "APP-" but force update is true
                // Move file to new folder structure
                $label = str_replace('_', ' ', ucwords(str_replace('_', ' ', $field)));
                $labelFolder = $this->sanitizeFolderName($label);
                $newPath = $newBaseFolder . '/' . $labelFolder . '/' . $fileName;

                if ($disk->exists($oldPath) && !$disk->exists($newPath)) {
                    $disk->makeDirectory(dirname($newPath));
                    $disk->move($oldPath, $newPath);
                    $attachment->$field = $newPath;
                    $updated = true;
                }
            }
        }

        if ($updated) {
            $attachment->save();
        }

        // 🔥 Clean up old folder if empty
        if ($disk->exists($oldBaseFolder) && count($disk->allFiles($oldBaseFolder)) == 0) {
            $disk->deleteDirectory($oldBaseFolder);
        }
    }

    public function dashboard()
    {
        $totalProperties  = Property::count();
        $totalPayments    = Payment::count();
        $totalPlotHistory = PlotHistory::count();
        $totalAttachments = Attchement::count();

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

/**
 * Show the add block form
 */
/**
 * Show the add block form
 */
/**
 * Show the add block form
 */
public function addblock()
{
    $sectors = Sector::orderBy('name')->get();

    $blocks = Block::with('sector')
        ->orderBy('sector_id')
        ->orderBy('name')
        ->get();

    return view('property.add-block', compact('sectors', 'blocks'));
}

/**
 * Store a new block
 */
public function storeBlock(Request $request)
{
    $request->validate([
        'sector_id' => 'required|exists:sectors,id',
        'name' => 'required|string|max:255|unique:blocks,name,NULL,id,sector_id,' . $request->sector_id,
    ]);

    try {
        Block::create([
            'sector_id' => $request->sector_id,
            'name' => $request->name,
        ]);

        return redirect()
            ->route('addBlock')
            ->with('success', 'Block added successfully.');

    } catch (\Exception $e) {

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

/**
 * Get blocks by sector
 */
public function getBlocksBySector($sectorId)
{
    $blocks = Block::where('sector_id', $sectorId)
        ->orderBy('name')
        ->get();

    return response()->json($blocks);
}

}
