<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\SmallRequest;
use Illuminate\Http\Request;

class HDMController extends Controller
{
    /**
     * Display a listing of pending requests for HDM.
     * Shows requests where request_type is 4 and deo_action is 1.
     */
    public function pendingRequests()
    {
        $town = json_decode(auth()->user()->town);

        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to array
        }

        $pendingApplications = Requests::with(['property', 'participants.owner', 'transfer'])

            ->where('request_type', 4)
            ->where('deo_action', 1)
            ->latest()
            ->paginate(15);


        return view('hdm.requests', compact('pendingApplications'));
    }

    public function viewPendingRequest($id){
         $smallRequest = SmallRequest::with(['property.owners', 'property.township'])->where('request_id', $id)->first();
                $request = Requests::with(['participants.owner', 'participants.representative'])->where('id', $id)->first();
                $property = $smallRequest->property;

                return view('hdm.viewRequest', compact('smallRequest', 'request', 'property'));
    }
    public function approvedRequests()
    {
        $pendingApplications = Requests::with(['property', 'participants.owner', 'transfer'])

            ->where('request_type', 4)
            ->where('head_status', 'accept')
            ->latest()
            ->paginate(15);


        return view('hdm.requests', compact('pendingApplications'));
    }
}
