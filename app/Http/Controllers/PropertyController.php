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
    /**
     * File field labels with their abbreviations.
     */
    private const FILE_FIELDS = [
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

    /**
     * Words to skip when building abbreviation.
     */
    private const SKIP_WORDS = ['of', 'the', 'a', 'an', 'against', 'and', 'or', 'to', 'for'];

    /**
     * Base storage folder.
     */
    private const BASE_FOLDER = 'MDA';

    /* ============================================================
     |  BLOCKS
     * ============================================================ */

    public function getBlocks($sectorId)
    {
        if (empty($sectorId) || $sectorId === '') {
            return response()->json([]);
        }

        $blocks = Block::where('sector_id', $sectorId)->orderBy('name')->get(['id', 'name']);
        return response()->json($blocks);
    }

    public function getBlocksBySector($sectorId)
    {
        $blocks = Block::where('sector_id', $sectorId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($blocks);
    }

    /* ============================================================
     |  BLOCK MANAGEMENT
     * ============================================================ */

    public function addblock()
    {
        $sectors = Sector::orderBy('name')->get(['id', 'name']);

        $blocks = Block::with('sector:id,name')
            ->orderBy('sector_id')
            ->orderBy('name')
            ->get(['id', 'sector_id', 'name']);

        return view('property.add-block', compact('sectors', 'blocks'));
    }

    public function storeBlock(Request $request)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
            'name'      => 'required|string|max:255|unique:blocks,name,NULL,id,sector_id,' . $request->sector_id,
        ]);

        try {
            Block::create([
                'sector_id' => $request->sector_id,
                'name'      => $request->name,
            ]);

            return redirect()->route('addBlock')->with('success', 'Block added successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /* ============================================================
     |  CRUD
     * ============================================================ */

    public function create()
    {
        $property = null;
        $sectors  = Sector::orderBy('name')->get(['id', 'name']);

        return view('property.form', compact('property', 'sectors'));
    }

    public function store(Request $request)
    {
        $this->validateProperty($request, false);

        DB::beginTransaction();

        try {
            // Resolve sector & block once
            $sector = Sector::findOrFail($request->sector_id);
            $block  = Block::findOrFail($request->block_id);

            // 1) Property
            $property = Property::create($this->buildPropertyData($request) + [
                'user_id' => auth()->id(),
            ]);

            // 2) Current Owners
            $this->saveCurrentOwners($request, $property);

            // 3) Payment
            $this->savePayment($request, $property);

            // 4) Plot History
            $this->savePlotHistory($request, $property);

            // 5) Attachment
            $attachmentData = [
                'property_id'         => $property->id,
                'alternate_allotment' => $request->alternate_allotment,
                'property_document'   => null,
                'status'              => false,
                'entry_date'          => null,
            ];

            $this->storeAttachmentFiles($request, $property, $attachmentData, $sector->name, $block->name);

            Attchement::create($attachmentData);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'An error occurred: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message'  => 'Property, current owners, payment, plot history and attachments saved successfully.',
                'redirect' => route('formList'),
            ]);
        }

        return redirect()->route('formList')
            ->with('success', 'Property, current owners, payment, plot history and attachments saved successfully.');
    }

    public function formList()
    {
        $data = Property::with([
                'payment:id,property_id,total_price,amount_deposited,remaining_amount',
                'plotHistories:id,property_id,name,father_name,id_card,challan_no',
                'attachment:id,property_id,property_document,status,entry_date',
                'sector:id,name',
                'block:id,name',
            ])
            ->where(function ($query) {
                $query->whereHas('attachment', fn($q) => $q->whereNull('entry_date'))
                      ->orWhereDoesntHave('attachment');
            })
            ->latest('id')
            ->get();

        return view('property.formlist', compact('data'));
    }

    public function entriesList()
    {
        $data = Property::with([
                'payment:id,property_id,total_price,amount_deposited,remaining_amount',
                'plotHistories:id,property_id,name,father_name,id_card,challan_no',
                'attachment:id,property_id,property_document,status,entry_date',
                'sector:id,name',
                'block:id,name',
            ])
            ->whereHas('attachment', fn($q) => $q->whereNotNull('entry_date'))
            ->latest('id')
            ->get();

        return view('property.Entries_List', compact('data'));
    }

    public function formDetail($id)
    {
        $property = Property::with([
                'payment',
                'plotHistories',
                'attachment',
                'sector:id,name',
                'block:id,name',
                'currentOwners',
            ])
            ->findOrFail($id);

        return view('property.formDetail', compact('property'));
    }

    public function formEdit($id)
    {
        $property = Property::with([
                'payment',
                'plotHistories',
                'attachment',
                'sector:id,name',
                'block:id,name',
                'currentOwners',
            ])
            ->findOrFail($id);

        $sectors = Sector::orderBy('name')->get(['id', 'name']);

        $blocks = $property->sector_id
            ? Block::where('sector_id', $property->sector_id)->orderBy('name')->get(['id', 'name'])
            : collect();

        return view('property.form-edit', compact('property', 'id', 'sectors', 'blocks'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        // Check existing document
        $existingAttachment = Attchement::where('property_id', $property->id)
            ->first(['id', 'property_id', 'property_document', 'status', 'entry_date']);

        $hasExistingDocument = $existingAttachment && !empty($existingAttachment->property_document);

        // Remove empty file inputs
        foreach (array_keys(self::FILE_FIELDS) as $field) {
            if ($request->has($field) && empty($request->$field)) {
                $request->request->remove($field);
            }
        }

        $this->validateProperty($request, $hasExistingDocument);

        DB::beginTransaction();

        try {
            $oldApplicationNo = (string) $property->application_no;
            $newApplicationNo = (string) $request->application_no;

            // Store originals BEFORE update
            $oldSectorId = $property->sector_id;
            $oldBlockId  = $property->block_id;
            $oldPlotNo   = $property->plot_no;

            $confirmChecked = $request->has('check_complete_file') && $request->check_complete_file == '1';
            $userId = $confirmChecked ? auth()->id() : $property->user_id;

            // 1) Update Property
            $property->update($this->buildPropertyData($request) + [
                'user_id' => $userId,
            ]);

            // 2) Current Owners
            $this->saveCurrentOwners($request, $property, true);

            // 3) Payment
            Payment::updateOrCreate(
                ['property_id' => $property->id],
                $this->buildPaymentData($request)
            );

            // 4) Plot History
            $this->savePlotHistory($request, $property, true);

            // 5) Detect changes
            $sectorChanged = $oldSectorId != $request->sector_id;
            $blockChanged  = $oldBlockId != $request->block_id;
            $plotChanged   = $oldPlotNo != $request->plot_no;
            $appChanged    = $oldApplicationNo !== $newApplicationNo;

            if ($sectorChanged || $blockChanged || $plotChanged || $appChanged) {
                $property->refresh();
                $property->load(['sector:id,name', 'block:id,name']);

                $this->renameAttachmentFolder(
                    $property,
                    $oldSectorId,
                    $oldBlockId,
                    $oldPlotNo,
                    $oldApplicationNo,
                    true
                );
            }

            // 6) Update Attachments
            $attachmentData = [
                'alternate_allotment' => $request->alternate_allotment,
                'complete_file_pages' => $request->complete_file_pages,
            ];

            $this->storeAttachmentFiles($request, $property, $attachmentData);

            $attachment = Attchement::where('property_id', $property->id)->first();

            $hasFile = $request->hasFile('property_document')
                    || ($attachment && !empty($attachment->property_document));

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
                    'message' => 'An error occurred: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function formDelete($id)
    {
        Property::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Entry deleted successfully.');
    }

    public function dashboard()
    {
        $totalProperties  = Property::count();
        $totalPayments    = Payment::count();
        $totalPlotHistory = PlotHistory::count();
        $totalAttachments = Attchement::count();

        $propertiesBySector = Property::with('sector:id,name')
            ->orderBy('sector_id')
            ->get(['id', 'sector_id'])
            ->groupBy(fn($p) => $p->sector->name ?? 'No Sector Assigned');

        $propertiesByBlock = Property::with('block:id,name')
            ->orderBy('block_id')
            ->get(['id', 'block_id'])
            ->groupBy(fn($p) => $p->block->name ?? 'No block Assigned');

        $propertiesByUser = Property::with('user:id,name')
            ->orderBy('user_id')
            ->get(['id', 'user_id'])
            ->groupBy(fn($p) => $p->user->name ?? 'Unknown User');

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

    /* ============================================================
     |  PRIVATE HELPERS — DATA BUILDERS
     * ============================================================ */

    private function buildPropertyData(Request $request): array
    {
        return [
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
            'transfer_count'       => $request->transfer_count,
            'ownership_type'       => $request->ownership_type,
            'allotment_type'       => $request->allotment_type,
        ];
    }

    private function buildPaymentData(Request $request): array
    {
        return [
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
        ];
    }

    private function saveCurrentOwners(Request $request, Property $property, bool $deleteOld = false): void
    {
        if (!$request->has('current_owners')) {
            return;
        }

        if ($deleteOld) {
            CurrentOwner::where('property_id', $property->id)->delete();
        }

        $rows = [];
        $now  = now();

        foreach ($request->current_owners as $ownerData) {
            if (empty($ownerData['applicant_name']) &&
                empty($ownerData['father_husband_name']) &&
                empty($ownerData['cnic']) &&
                empty($ownerData['old_nic'])) {
                continue;
            }

            $ownerData['property_id'] = $property->id;
            $ownerData['created_at']  = $now;
            $ownerData['updated_at']  = $now;
            $rows[] = $ownerData;
        }

        if (!empty($rows)) {
            CurrentOwner::insert($rows);
        }
    }

    private function savePayment(Request $request, Property $property): void
    {
        Payment::create($this->buildPaymentData($request) + [
            'property_id' => $property->id,
        ]);
    }

    private function savePlotHistory(Request $request, Property $property, bool $deleteOld = false): void
    {
        if (!$request->has('transferees')) {
            return;
        }

        if ($deleteOld) {
            PlotHistory::where('property_id', $property->id)->delete();
        }

        $rows = [];
        $now  = now();

        foreach ($request->transferees as $row) {
            if (empty($row['name']) &&
                empty($row['father_name']) &&
                empty($row['id_card']) &&
                empty($row['challan_no']) &&
                empty($row['address']) &&
                empty($row['allottee_date'])) {
                continue;
            }

            $rows[] = [
                'property_id'   => $property->id,
                'name'          => $row['name'] ?? null,
                'father_name'   => $row['father_name'] ?? null,
                'id_card'       => $row['id_card'] ?? null,
                'challan_no'    => $row['challan_no'] ?? null,
                'address'       => $row['address'] ?? null,
                'allottee_date' => $row['allottee_date'] ?? null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        if (!empty($rows)) {
            PlotHistory::insert($rows);
        }
    }

    /* ============================================================
     |  PRIVATE HELPERS — VALIDATION
     * ============================================================ */

    private function validateProperty(Request $request, bool $hasExistingDocument): void
    {
        $propertyDocumentRule = $hasExistingDocument ? 'nullable|file' : 'required|file';

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
            'amount_deposited'        => 'nullable|numeric',
            'remaining_amount'        => 'nullable|numeric',
            'down_payment'            => 'nullable|numeric',
            'initial_notice_no'       => 'nullable|string',
            'initial_notice_date'     => 'nullable|date',
            'total_received_amount'   => 'nullable|numeric',
            'received_amount_date'    => 'nullable|date',
            'allotment_order_no'      => 'nullable|string',
            'allotment_order_date'    => 'nullable|date',
            'possession_slip_no'      => 'nullable|string',
            'possession_slip_date'    => 'nullable|date',
            'boundary_wall_approval'  => 'nullable|string',
            'map_approval_date'       => 'nullable|date',
            'transfer_order_no'       => 'nullable|string',

            // Step 3
            'transferees'                  => 'nullable|array',
            'transferees.*.name'          => 'nullable|string',
            'transferees.*.father_name'   => 'nullable|string',
            'transferees.*.id_card'       => 'nullable|string',
            'transferees.*.challan_no'    => 'nullable|string',
            'transferees.*.address'       => 'nullable|string',
            'transferees.*.allottee_date' => 'nullable|date',

            'current_owners'                          => 'nullable|array',
            'current_owners.*.applicant_name'         => 'nullable|string|max:255',
            'current_owners.*.father_husband_name'    => 'nullable|string|max:255',
            'current_owners.*.old_nic'                => 'nullable|string|max:50',
            'current_owners.*.cnic'                   => 'nullable|string|max:15',
            'current_owners.*.address_temporary'      => 'nullable|string',
            'current_owners.*.address_permanent'      => 'nullable|string',

            // Step 4
            'alternate_allotment'          => 'nullable|string',
            'complete_file_pages'          => 'nullable|integer',
            'property_document'            => $propertyDocumentRule,
            'adjacent_area_allotment'      => 'nullable|file',
            'allotment_order'              => 'nullable|file',
            'decision_courts'              => 'nullable|file',
            'decision_allotment_committee' => 'nullable|file',
            'decision_mda_board'           => 'nullable|file',
            'decision_revising_authority'  => 'nullable|file',
            'noting_file'                  => 'nullable|file',
            'cnic_front'                   => 'nullable|file',
        ]);
    }

    /* ============================================================
     |  PRIVATE HELPERS — FILESYSTEM
     * ============================================================ */

    /**
     * Build short abbreviation from a label.
     * Example: "Property Document" => "PD"
     *          "Decision of Courts Against Plot" => "DCP"
     */
    private function getFieldAbbreviation(string $label): string
    {
        $words = preg_split('/[\s_]+/', trim($label));
        $abbr  = '';

        foreach ($words as $word) {
            $word = preg_replace('/[^A-Za-z0-9]/', '', $word);
            if ($word !== '' && !in_array(strtolower($word), self::SKIP_WORDS, true)) {
                $abbr .= strtoupper($word[0]);
            }
        }

        return $abbr !== '' ? $abbr : 'FILE';
    }

    private function sanitizeFolderName(?string $name, int $fallbackId = 0): string
    {
        $folderName = preg_replace('/[^A-Za-z0-9_\-]/', '_', trim((string) $name));
        $folderName = trim($folderName, '_');

        return $folderName !== '' ? $folderName : ('item_' . $fallbackId);
    }

    /**
     * Build the base folder path:
     * MDA/{Sector}/{Block}/{PlotNo}
     */
    private function buildBaseFolder(?string $sectorName, ?string $blockName, ?string $plotNo, int $fallbackId = 0): string
    {
        $sector = $this->sanitizeFolderName($sectorName ?? 'No_Sector');
        $block  = $this->sanitizeFolderName($blockName ?? 'No_Block');
        $plot   = $this->sanitizeFolderName($plotNo ?? 'No_Plot', $fallbackId);

        return self::BASE_FOLDER . '/' . $sector . '/' . $block . '/' . $plot;
    }

    /**
     * Store uploaded files in: MDA/Sector/Block/PlotNo/{FieldAbbr}/
     */
    private function storeAttachmentFiles(
        Request $request,
        Property $property,
        array &$attachmentData,
        ?string $sectorName = null,
        ?string $blockName = null
    ): void {
        // Resolve sector / block names
        if (!$sectorName && $property->sector) {
            $sectorName = $property->sector->name;
        }
        if (!$blockName && $property->block) {
            $blockName = $property->block->name;
        }

        $baseFolder = $this->buildBaseFolder(
            $sectorName,
            $blockName,
            $property->plot_no,
            $property->id
        );

        $plotSanitized   = $this->sanitizeFolderName($property->plot_no ?? 'PLOT', $property->id);
        $sectorSanitized = $this->sanitizeFolderName($sectorName ?? 'SECTOR');

        $disk = Storage::disk('public');

        // Fetch existing attachment ONCE
        $existingAttachment = Attchement::where('property_id', $property->id)
            ->first(['id', 'property_id', 'property_document', 'adjacent_area_allotment',
                     'allotment_order', 'decision_courts', 'decision_allotment_committee',
                     'decision_mda_board', 'decision_revising_authority', 'noting_file', 'cnic_front']);

        foreach (self::FILE_FIELDS as $field => $label) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);

                $abbr       = $this->getFieldAbbreviation($label);
                $folderPath = $baseFolder . '/' . $abbr;

                $extension = $file->getClientOriginalExtension();
                $fileName  = $plotSanitized . '_' . $sectorSanitized . '.' . $extension;

                // Avoid collision
                if ($disk->exists($folderPath . '/' . $fileName)) {
                    $fileName = $plotSanitized . '_' . $sectorSanitized . '_' . uniqid() . '.' . $extension;
                }

                // Delete old file
                if ($existingAttachment && !empty($existingAttachment->$field)) {
                    $old = $existingAttachment->$field;
                    if ($disk->exists($old)) {
                        $disk->delete($old);
                    }
                }

                $attachmentData[$field] = $file->storeAs($folderPath, $fileName, 'public');

            } elseif ($existingAttachment && !empty($existingAttachment->$field)) {
                $attachmentData[$field] = $existingAttachment->$field;
            }
        }
    }

    /**
     * Move & rename files when sector / block / plot / application changes.
     */
    private function renameAttachmentFolder(
        Property $property,
        $oldSectorId,
        $oldBlockId,
        $oldPlotNo,
        string $oldApplicationNo,
        bool $forceUpdate = false
    ): void {
        $disk = Storage::disk('public');

        $attachment = Attchement::where('property_id', $property->id)->first();

        if (!$attachment) {
            return;
        }

        // New base folder
        $newBaseFolder = $this->buildBaseFolder(
            $property->sector->name ?? 'No_Sector',
            $property->block->name  ?? 'No_Block',
            $property->plot_no,
            $property->id
        );

        // Old base folder
        $oldSectorName = $oldSectorId ? (Sector::find($oldSectorId)->name ?? 'No_Sector') : 'No_Sector';
        $oldBlockName  = $oldBlockId  ? (Block::find($oldBlockId)->name  ?? 'No_Block')  : 'No_Block';

        $oldBaseFolder = $this->buildBaseFolder($oldSectorName, $oldBlockName, $oldPlotNo, $property->id);

        if ($oldBaseFolder === $newBaseFolder && !$forceUpdate) {
            return;
        }

        $plotSanitized   = $this->sanitizeFolderName($property->plot_no ?? 'PLOT', $property->id);
        $sectorSanitized = $this->sanitizeFolderName($property->sector->name ?? 'SECTOR');

        $updated = false;

        foreach (self::FILE_FIELDS as $field => $label) {
            if (empty($attachment->$field)) {
                continue;
            }

            $oldPath   = $attachment->$field;
            $extension = pathinfo($oldPath, PATHINFO_EXTENSION);

            $abbr = $this->getFieldAbbreviation($label);

            $newFileName = $plotSanitized . '_' . $sectorSanitized . '.' . $extension;
            $newPath     = $newBaseFolder . '/' . $abbr . '/' . $newFileName;

            if ($disk->exists($newPath)) {
                $newFileName = $plotSanitized . '_' . $sectorSanitized . '_' . uniqid() . '.' . $extension;
                $newPath     = $newBaseFolder . '/' . $abbr . '/' . $newFileName;
            }

            if ($disk->exists($oldPath)) {
                $disk->makeDirectory(dirname($newPath));
                $disk->move($oldPath, $newPath);

                $attachment->$field = $newPath;
                $updated = true;
            }
        }

        if ($updated) {
            $attachment->save();
        }

        // Cleanup empty old folder
        if ($disk->exists($oldBaseFolder)) {
            $remaining = $disk->allFiles($oldBaseFolder);
            if (empty($remaining)) {
                $disk->deleteDirectory($oldBaseFolder);
            }
        }
    }
}
