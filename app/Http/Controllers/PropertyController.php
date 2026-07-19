<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Payment;
use App\Models\PlotHistory;
use App\Models\Attchement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**
     * Show the multi-step form (create).
     */
    public function create()
    {
        $property = null;
        return view('property.form', compact('property'));
    }
    public function store(Request $request)
    {

        $request->validate([
            // Step 1
            'application_no'        => 'nullable|string',
            'application_date'      => 'nullable|date',
            'plot_no'                => 'nullable',
            'sector'                  => 'nullable|string',
            'block'                   => 'nullable|string',
            'kanal'                   => 'nullable|numeric',
            'marla'                   => 'nullable|numeric',
            'sqrft'                    => 'nullable|numeric',
            'approved_scheme'        => 'nullable|string',
            'initial_draft_amount'  => 'nullable|numeric',
            'initial_draft_date'    => 'nullable|date',
            'applicant_name'         => 'nullable|string',
            'father_husband_name'   => 'nullable|string',
            'old_nic'                 => 'nullable',
            'cnic'                    => 'nullable|string',
            'address_temporary'      => 'nullable|string',
            'address_permanent'      => 'nullable|string',
            'category'                => 'nullable|string',
            'mode_allottment'        => 'nullable|string',
            'allotment_date'      => 'nullable|date',
            'balloting_serial_no'   => 'nullable',

            // Step 2
            'total_price'             => 'nullable|numeric',
            'amount_deposited'       => 'nullable|numeric',
            'remaining_amount'       => 'nullable|numeric',
            'down_payment'            => 'nullable|numeric',
            'initial_notice_no'      => 'nullable|string',
            'initial_notice_date'    => 'nullable|date',
            'total_received_amount' => 'nullable|numeric',
            'received_amount_date'  => 'nullable|date',
            'allotment_order_no'    => 'nullable',
            'allotment_order_date'  => 'nullable|date',
            'possession_slip_no'    => 'nullable',
            'possession_slip_date'  => 'nullable|date',
            'boundary_wall_approval' => 'nullable',
            'map_approval_date'      => 'nullable|date',
            'transfer_order_no'      => 'nullable',

            // Step 3
            'transferees'               => 'nullable|array',
            'transferees.*.name'       => 'nullable|string',
            'transferees.*.id_card'   => 'nullable',
            'transferees.*.challan_no' => 'nullable',

            // Step 4
            'alternate_allotment'          => 'nullable|string',
            'complete_property_file'       => 'nullable|file|max:5120',
            'adjacent_area_allotment'      => 'nullable|file|max:5120',
            'division_of_plots'            => 'nullable|file|max:5120',
            'decision_courts'              => 'nullable|file|max:5120',
            'decision_allotment_committee' => 'nullable|file|max:5120',
            'decision_mda_board'           => 'nullable|file|max:5120',
            'decision_revising_authority'  => 'nullable|file|max:5120',
        ]);

        DB::beginTransaction();

        try {
            // 1) Property
            $property = Property::create([
                'application_no'       => $request->application_no,
                'application_date'     => $request->application_date,
                'plot_no'               => $request->plot_no,
                'sector'                 => $request->sector,
                'block'                  => $request->block,
                'kanal'                  => $request->kanal,
                'marla'                  => $request->marla,
                'sqrft'                   => $request->sqrft,
                'approved_scheme'       => $request->approved_scheme,
                'initial_draft_amount' => $request->initial_draft_amount,
                'initial_draft_date'   => $request->initial_draft_date,
                'applicant_name'        => $request->applicant_name,
                'father_husband_name'  => $request->father_husband_name,
                'old_nic'                => $request->old_nic,
                'cnic'                   => $request->cnic,
                'address_temporary'     => $request->address_temporary,
                'address_permanent'     => $request->address_permanent,
                'category'               => $request->category,
                'mode_allottment'       => $request->mode_allottment,
                'allotment_date'        => $request->allotment_date,
                'balloting_serial_no'  => $request->balloting_serial_no,
                'user_id'                => auth()->id(),
            ]);
            return response()->json($request->all());

            // 2) Payment
            Payment::create([
                'property_id'             => $property->id,
                'total_price'              => $request->total_price,
                'amount_deposited'        => $request->amount_deposited,
                'remaining_amount'        => $request->remaining_amount,
                'down_payment'             => $request->down_payment,
                'initial_notice_no'       => $request->initial_notice_no,
                'initial_notice_date'     => $request->initial_notice_date,
                'total_received_amount'  => $request->total_received_amount,
                'received_amount_date'   => $request->received_amount_date,
                'allotment_order_no'     => $request->allotment_order_no,
                'allotment_order_date'   => $request->allotment_order_date,
                'possession_slip_no'     => $request->possession_slip_no,
                'possession_slip_date'   => $request->possession_slip_date,
                'boundary_wall_approval' => $request->boundary_wall_approval,
                'map_approval_date'       => $request->map_approval_date,
                'transfer_order_no'       => $request->transfer_order_no,
            ]);

            // 3) Plot History (transferees) — repeatable rows, empty rows skip ho jate hain
            if ($request->has('transferees')) {
                foreach ($request->transferees as $row) {
                    if (empty($row['name']) && empty($row['id_card']) && empty($row['challan_no'])) {
                        continue;
                    }
                    PlotHistory::create([
                        'property_id' => $property->id,
                        'name'         => $row['name'] ?? null,
                        'id_card'     => $row['id_card'] ?? null,
                        'challan_no' => $row['challan_no'] ?? null,
                    ]);
                }
            }

            // 4) Attachment (files)
            $fileFields = [
                'complete_property_file', 'adjacent_area_allotment', 'division_of_plots',
                'decision_courts', 'decision_allotment_committee',
                'decision_mda_board', 'decision_revising_authority',
            ];

            $attachmentData = [
                'property_id'          => $property->id,
                'alternate_allotment'  => $request->alternate_allotment,
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $attachmentData[$field] = $request->file($field)->store('attachments', 'public');
                }
            }

            Attchement::create($attachmentData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
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
    public function formList()
    {
        $data = Property::with(['payment', 'plotHistories', 'attachment'])->latest()->get();
        return view('property.formlist', compact('data'));
    }

    /**
     * Show a single property's full detail.
     */
    public function formDetail($id)
    {
        $property = Property::with(['payment', 'plotHistories', 'attachment'])->findOrFail($id);
        return view('property.formDetail', compact('property'));
    }

    /**
     * Edit form for an existing property.
     */
    public function formEdit($id)
    {
        $property = Property::with(['payment', 'plotHistories', 'attachment'])->findOrFail($id);
        return view('property.form-edit', compact('property'));
    }

    /**
     * Update an existing property record (all 4 tables).
     */
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $property->update([
            'application_no'       => $request->application_no,
            'application_date'     => $request->application_date,
            'plot_no'               => $request->plot_no,
            'sector'                 => $request->sector,
            'block'                  => $request->block,
            'kanal'                  => $request->kanal,
            'marla'                  => $request->marla,
            'sqrft'                   => $request->sqrft,
            'approved_scheme'       => $request->approved_scheme,
            'initial_draft_amount' => $request->initial_draft_amount,
            'initial_draft_date'   => $request->initial_draft_date,
            'applicant_name'        => $request->applicant_name,
            'father_husband_name'  => $request->father_husband_name,
            'old_nic'                => $request->old_nic,
            'cnic'                   => $request->cnic,
            'address_temporary'     => $request->address_temporary,
            'address_permanent'     => $request->address_permanent,
            'category'               => $request->category,
            'mode_allottment'       => $request->mode_allottment,
            'allotment_date'        => $request->allotment_date,
            'balloting_serial_no'  => $request->balloting_serial_no,
        ]);

        Payment::updateOrCreate(
            ['property_id' => $property->id],
            [
                'total_price'             => $request->total_price,
                'amount_deposited'       => $request->amount_deposited,
                'remaining_amount'       => $request->remaining_amount,
                'down_payment'            => $request->down_payment,
                'initial_notice_no'      => $request->initial_notice_no,
                'initial_notice_date'    => $request->initial_notice_date,
                'total_received_amount' => $request->total_received_amount,
                'received_amount_date'  => $request->received_amount_date,
                'allotment_order_no'    => $request->allotment_order_no,
                'allotment_order_date'  => $request->allotment_order_date,
                'possession_slip_no'    => $request->possession_slip_no,
                'possession_slip_date'  => $request->possession_slip_date,
                'boundary_wall_approval' => $request->boundary_wall_approval,
                'map_approval_date'      => $request->map_approval_date,
                'transfer_order_no'      => $request->transfer_order_no,
            ]
        );

        if ($request->has('transferees')) {
            // Purani entries hata ke nayi list se replace kar dete hain
            PlotHistory::where('property_id', $property->id)->delete();

            foreach ($request->transferees as $row) {
                if (empty($row['name']) && empty($row['id_card']) && empty($row['challan_no'])) {
                    continue;
                }
                PlotHistory::create([
                    'property_id' => $property->id,
                    'name'         => $row['name'] ?? null,
                    'id_card'     => $row['id_card'] ?? null,
                    'challan_no' => $row['challan_no'] ?? null,
                ]);
            }
        }

        $fileFields = [
            'complete_property_file', 'adjacent_area_allotment', 'division_of_plots',
            'decision_courts', 'decision_allotment_committee',
            'decision_mda_board', 'decision_revising_authority',
        ];

        $attachmentData = ['alternate_allotment' => $request->alternate_allotment];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $attachmentData[$field] = $request->file($field)->store('attachments', 'public');
            }
        }

        Attchement::updateOrCreate(
            ['property_id' => $property->id],
            $attachmentData
        );

        return redirect()->route('formList')->with('success', 'Property updated successfully.');
    }


    public function formDelete($id)
    {
        Property::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Entry deleted successfully.');
    }
}
