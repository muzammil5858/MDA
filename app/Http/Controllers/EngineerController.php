<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\SmallRequest;
use App\Models\MapApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EngineerController extends Controller
{
    public function pendingRequests()
    {

        $pendingApplications = Requests::with(['property', 'participants.owner', 'transfer'])

            ->where('request_type', 4)
            ->where('deo_action','=',1)
              ->where(function ($q) {
                $q->WhereNull('engineer_status');
            })
            ->paginate(15);



        return view('engineer.requests', compact('pendingApplications'));
    }

    public function viewPendingRequest($id){
         $smallRequest = SmallRequest::with(['property.owners', 'property.township'])->where('request_id', $id)->first();
                $request = Requests::with(['participants.owner', 'participants.representative'])->where('id', $id)->first();
                $property = $smallRequest->property;

                return view('engineer.viewRequest', compact('smallRequest', 'request', 'property'));
    }
    public function approvedRequests()
    {
        $pendingApplications = Requests::with(['property', 'participants.owner', 'transfer'])
        ->where('request_type', 4)
        ->where('engineer_status', 1)
        ->latest()
        ->paginate(15);


        return view('engineer.requests', compact('pendingApplications'));
    }
    public function mapApproval($id)
    {
        $property = Requests::with('property')->findOrFail($id)->property;
        $mapApproval = MapApproval::where('request_id', $id)->first();
        return view('engineer.mapapprovalform',['property'=>$property, 'request_id' => $id, 'mapApproval' => $mapApproval]);
    }

    /**
     * Store map approval form data
     */
    public function storeMapApproval(Request $request)
    {
        $userId = Auth::id();
        $requestId = $request->input('request_id');
        $propertyId = $request->input('property_id');

        $data = [
            'user_id' => $userId,
            'request_id' => $requestId,
            'property_id' => $propertyId,
            'drawing_no' => $request->input('drawing_no'),
            'drawing_date' => $request->input('drawing_date'),
            'drawing_location' => $request->input('drawing_location'),
            'allocated_area' => $request->input('allocated_area'),
            'road_location' => $request->input('road_location'),
            'construction_status' => $request->input('construction_status'),
            'plot_size_status' => $request->input('plot_size_status'),
            'added_area_sq_yards' => $request->input('added_area_sq_yards'),
            'additional_remarks' => $request->input('additional_remarks'),
            'impact_on_public' => $request->input('impact_on_public'),
            'graveyard_status' => $request->input('graveyard_status'),
            'separate_plot' => $request->input('separate_plot'),
            'tor_compliance' => $request->input('tor_compliance'),
            'existing_condition' => $request->input('existing_condition'),
            'status' => 'submitted',
        ];

        // Check if record exists and update, otherwise create
        $mapApproval = MapApproval::where('request_id', $requestId)
            ->where('user_id', $userId)
            ->first();

        if ($mapApproval) {
            $mapApproval->update($data);
            $message = 'Map approval form updated successfully!';
        } else {
            MapApproval::create($data);
            $message = 'Map approval form submitted successfully!';
        }

        return redirect()->route('engineer.map-approvals-list')
            ->with('success', $message);
    }

    /**
     * List all submitted map approvals
     */
    public function mapApprovalsList()
    {
        $pendingApplications = MapApproval::with(['request', 'request.property', 'request.participants.owner'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);


        return view('engineer.mapapprovals-list', compact('pendingApplications'));
    }

    /**
     * Edit map approval form
     */
    public function editMapApproval($id)
    {
        $mapApproval = MapApproval::findOrFail($id);

        // Check authorization
        if ($mapApproval->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $property = $mapApproval->property ?? $mapApproval->request->property;
        $requestId = $mapApproval->request_id;

        return view('engineer.mapapprovalform', [
            'property' => $property,
            'request_id' => $requestId,
            'mapApproval' => $mapApproval
        ]);
    }

    /**
     * Delete map approval
     */
    public function deleteMapApproval($id)
    {
        $mapApproval = MapApproval::findOrFail($id);

        if ($mapApproval->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $mapApproval->delete();

        return redirect()->route('engineer.map-approvals-list')
            ->with('success', 'Map approval deleted successfully!');
    }
}
