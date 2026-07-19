<?php

namespace App\Http\Controllers;

use App\Models\Attchement;
use Illuminate\Http\Request;

class AttchementController extends Controller
{
    protected $fileFields = [
        'complete_property_file', 'adjacent_area_allotment', 'division_of_plots',
        'decision_courts', 'decision_allotment_committee',
        'decision_mda_board', 'decision_revising_authority',
    ];

    public function update(Request $request, $propertyId)
    {
        $attachment = Attchement::where('property_id', $propertyId)->firstOrFail();

        $data = ['alternate_allotment' => $request->alternate_allotment];

        foreach ($this->fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('attachments', 'public');
            }
        }

        $attachment->update($data);

        return redirect()->back()->with('success', 'Attachment updated.');
    }
}
