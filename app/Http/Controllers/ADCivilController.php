<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requests;
use App\Models\SmallRequest;
use App\Models\MapApproval;

class ADCivilController extends Controller
{
    public function pendingRequests()
    {
        // Logic to fetch pending requests for AD-Civil
        $pendingApplications = Requests::with(['property', 'participants.owner', 'transfer'])
            ->where('request_type', 4)
            ->where('ad_status', NULL)
            ->where('head_status', 'accept') // Assuming AD-Civil sees requests approved by HDM
            ->latest()
            ->paginate(15);
        return view('ad-civil.pendingRequests', compact('pendingApplications'));
    }

    public function approvedRequests()
    {
       $pendingApplications = Requests::with(['property', 'participants.owner', 'transfer'])
            ->where('request_type', 4)
            ->where('ad_status', 1)
            ->where('head_status', 'accept') // Assuming AD-Civil sees requests approved by HDM
            ->latest()
            ->paginate(15);
        return view('ad-civil.acceptedRequest', compact('pendingApplications'));
    }

    public function viewPendingRequest($id)
    {
        // Logic to view details of a specific pending request for AD-Civil
         $smallRequest = SmallRequest::with(['property.owners', 'property.township'])->where('request_id', $id)->first();
                $request = Requests::with(['participants.owner', 'participants.representative'])->where('id', $id)->first();
                $property = $smallRequest->property;
                $mapApproval = MapApproval::where('request_id', $id)->first();


                return view('ad-civil.actionPendingRequest', compact('smallRequest', 'request', 'property', 'mapApproval'));
    }
    public function submitPendingRequest(Request $request, $id)
    {
         $data = $request->validate([
            'verify_status' => 'required',
            'remarks'       => 'nullable',
            'date'          => 'required',
        ]);

        // Role-based update
        if (auth()->user()->hasRole('AD-Civil')) {
            Requests::where('id', $id)->update([
                'ad_status'  => $request->verify_status,
                'ad_date'    => $data['date'],
                'ad_remarks' => $data['remarks'],
                'ad_id' => auth()->id(),
            ]);
        }

        return redirect()->route('ad-civil.pendingRequests')->with('success', 'Request has been approved and submitted successfully.');
    }

}
