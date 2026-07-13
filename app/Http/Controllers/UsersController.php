<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Property;
use App\Models\Schedule;
use App\Models\TransferFile;
use Illuminate\Http\Request;
use App\Models\Requests;
use App\Models\User;
use PhpParser\Node\Expr\AssignOp\Plus;
use DB;

class UsersController extends Controller
{
    public function propertyList()
    {
        $cnic = auth()->user()->cnic;
        $properties = Property::where('cnic', $cnic)->get();
        $status = null;

        return view('user.propertylist', compact('properties', 'status'));
    }
    public function transferFileEdit($id)
    {
        $exist = DB::table('transfer_files')->where('request_id', $id)->first();

        $request = DB::table('requests')->where('id', $id)->first();
        $property = Property::where('id', $exist->property_id)->first();

        if ($request->request_type == 1) {
            return view('user.transferFileEdit', compact('property', 'exist'));
        } else if ($request->request_type == 4) {
            return view('user.warasatFileEdit', compact('property', 'exist'));
        }
    }
    public function transferFile($id)
    {
        $type = request()->query('type');

        $exist = DB::table('transfer_files')->where('property_id', $id)->latest()->first();
        if ($exist && ($exist->verify_status == null || $exist->verify_status == 'Yes')) {
            return redirect()->back()->with('warning', 'Your Previous Request is either Pending or Accepted. You cannot request again.');
        }
        $property = Property::where('id', $id)->first();
        if ($type == 1) {
            return view('user.transferfile', compact('property', 'type'));
        }
        if ($type == 4) {
            return view('user.warasat', compact('property', 'type'));
        }
    }
    public function transferFileUpdate(Request $request, $id)
    {

        $rules = [
            'town' => 'required',
            'kanal' => '',
            'marla' => '',
            'sqrft' => '',
            'declarer_name' => 'required|string|max:255',
            'declarer_fname' => 'required|string|max:255',
            'declarer_cnic' => 'required|digits:13',
            'transferee_name' => 'required|string|max:255',
            'transferee_fname' => 'required|string|max:255',
            'tranferee_cnic' => 'required|digits:13',
        ];

        // Conditional validation based on type
        if ($request->type == 1) {
            $rules['amount'] = 'required';
            $rules['cnic_front'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $rules['cnic_back'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        } elseif ($request->type == 4) {
            $rules['death_date'] = 'required|date';
            $rules['death_certificate'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        // Validate once
        $validatedData = $request->validate($rules);




        // Store the data in the database
        $data = [
            'town_id' => $validatedData['town'],
            'declarer_name' => $validatedData['declarer_name'],
            'declarer_fname' => $validatedData['declarer_fname'],
            'declarer_cnic' => $validatedData['declarer_cnic'],
            'transferee_name' => $validatedData['transferee_name'],
            'transferee_fname' => $validatedData['transferee_fname'],
            'tranferee_cnic' => $validatedData['tranferee_cnic'],
            'kanal' => $validatedData['kanal'],
            'marla' => $validatedData['marla'],
            'sqrft' => $validatedData['sqrft'],
            'sector' => $request->sector,

            'user_id' => auth()->user()->id,
        ];
        if ($request->type == 1) {
            $data['amount'] = $validatedData['amount'];
        }
        if ($request->type == 4) {
            $data['death_date'] = $validatedData['death_date'];
        }

        if ($request->hasFile('death_certificate')) {
            $originalName = $request->file('death_certificate')->getClientOriginalName();
            $fileName = uniqid() . '_' . $originalName;
            $data['death_certificate'] = $fileName;
            $request->file('death_certificate')->move(public_path('uploads/user/death_certificate'), $fileName);
        }

        if ($request->hasFile('cnic_front')) {
            $originalName = $request->file('cnic_front')->getClientOriginalName();
            $fileName = uniqid() . '_' . $originalName;
            $data['cnic_front'] = $fileName;
            $request->file('cnic_front')->move(public_path('uploads/user/cnics/'), $fileName);
        }

        if ($request->hasFile('cnic_back')) {
            $originalName = $request->file('cnic_back')->getClientOriginalName();
            $fileName = uniqid() . '_' . $originalName;
            $data['cnic_back'] = $fileName;
            $request->file('cnic_back')->move(public_path('uploads/user/cnics/'), $fileName);
        }


        $iid = DB::table('transfer_files')->where('request_id', $id)->where('verify_status', null)->latest()->first();

        TransferFile::where('id', $iid->id)->update($data);
        // dd($data);
        return redirect('/track-application')->with('success', 'Trnasfer Request Data Updated Successfully.');
    }



    public function store(Request $request, $id)
    {


        $rules = [
            'town' => 'required',
            'kanal' => '',
            'marla' => '',
            'sqrft' => '',
            'declarer_name' => 'required|string|max:255',
            'declarer_fname' => 'required|string|max:255',
            'declarer_cnic' => 'required|digits:13',
            'transferee_name' => 'required|string|max:255',
            'transferee_fname' => 'required|string|max:255',
            'tranferee_cnic' => 'required|digits:13',
        ];

        // Conditional validation based on type
        if ($request->type == 1) {
            $rules['amount'] = 'required';
            $rules['cnic_front'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $rules['cnic_back'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        } elseif ($request->type == 4) {
            $rules['death_date'] = 'required|date';
            $rules['death_certificate'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        // Validate once
        $validatedData = $request->validate($rules);

        $data = [
            'town_id' => $validatedData['town'],
            'declarer_name' => $validatedData['declarer_name'],
            'declarer_fname' => $validatedData['declarer_fname'],
            'declarer_cnic' => $validatedData['declarer_cnic'],
            'transferee_name' => $validatedData['transferee_name'],
            'transferee_fname' => $validatedData['transferee_fname'],
            'tranferee_cnic' => $validatedData['tranferee_cnic'],
            'kanal' => $validatedData['kanal'],
            'marla' => $validatedData['marla'],
            'sqrft' => $validatedData['sqrft'],
            'sector' => $request->sector,
            'property_id' => $id,
            'user_id' => auth()->user()->id,
        ];

        if ($request->type == 1) {
            $data['amount'] = $validatedData['amount'];
        }
        if ($request->type == 4) {
            $data['death_date'] = $validatedData['death_date'];
        }

        if ($request->hasFile('death_certificate')) {
            $originalName = $request->file('death_certificate')->getClientOriginalName();
            $fileName = uniqid() . '_' . $originalName;
            $data['death_certificate'] = $fileName;
            $request->file('death_certificate')->move(public_path('uploads/user/death_certificate'), $fileName);
        }

        if ($request->hasFile('cnic_front')) {
            $originalName = $request->file('cnic_front')->getClientOriginalName();
            $fileName = uniqid() . '_' . $originalName;
            $data['cnic_front'] = $fileName;
            $request->file('cnic_front')->move(public_path('uploads/user/cnics/'), $fileName);
        }

        if ($request->hasFile('cnic_back')) {
            $originalName = $request->file('cnic_back')->getClientOriginalName();
            $fileName = uniqid() . '_' . $originalName;
            $data['cnic_back'] = $fileName;
            $request->file('cnic_back')->move(public_path('uploads/user/cnics/'), $fileName);
        }



        $requestData = [
            'town' => $validatedData['town'],
            'property_id' => $id,
            'request_type' => $request->type,
            'sector' => $request->sector,
            'user_id' => auth()->user()->id,
        ];


        $req = Requests::create($requestData);
        $data['request_id'] = $req->id;

        // Save data to the database
        TransferFile::create($data);

        // Redirect or return a response
        return redirect('/properties-list')->with('success', 'Trnasfer Request Submitted Successfully.');
    }

    public function bookAppointment(Request $request)
    {
        $id = $request->property;


        $curr_datetime = now()->format('Y-m-d H:i:s');
        $check = DB::table('appointment')
            ->leftJoin('schedules', 'schedules.id', '=', 'appointment.schedule_id')
            ->where('property_id', $id)
            ->select(DB::raw('DATE(end_dateTime) as end_date'))
            ->latest('appointment.created_at')
            ->first();



        if ($check == null) {
            $check = false;
        } elseif ($check->end_date < $curr_datetime) {
            $check = false;
        } elseif ($check->end_date > $curr_datetime) {
            $check = true;
        }




        $schedules = DB::select("SELECT * FROM schedules WHERE start_datetime > ? and town = ?", [$curr_datetime, $request->id]);
        $track = DB::table("transfer_files")->select('amount')->where('property_id', $id)->latest()->first();


        $dates =  DB::select("SELECT id,start_datetime FROM schedules WHERE start_datetime > ? and town = ?", [$curr_datetime, $request->id]);
        $type = DB::table('towns')->get();
        return view('user.bookappoint', compact('schedules', 'type', 'dates', 'id', 'check', 'track'));
    }
    public function appointmentDetail(Request $request)
    {
        $schedule = Schedule::find($request->id); // Replace 1 with the schedule ID you want to check

        if ($schedule->hasMaxAppointments()) {
            return response()->json(['status' => 201, 'message' => 'This schedule is fully booked.Pleas select another appointment date.'], 201);
        } else {
            return response()->json(['status' => 200, 'message' => 'Slots are available.', 'schedule' => $schedule], 200);
        }
    }

    public function appointment(Request $request)
    {


        $request->validate([
            'date' => 'required',
            'id' => 'required',
        ]);


        $data['town_id'] = $request->town;
        $data['property_id'] = $request->id;
        $data['schedule_id'] = $request->date;
        $data['user_id'] = auth()->user()->id;
        $data['booking_date'] = now()->format('Y-m-d');

        $appoint = Appointment::create($data);

        $req = Requests::where('property_id', $request->id)->latest()->first();

        $req = Requests::where('id', $req->id)->update(['appointment' => 1]);
        return redirect()->back()->with('success', 'You have booked your appointment Successfully.');
    }

    public function bookedAppointment()
    {
        return view('user.appointmentbooked');
    }
    public function AppointmentBook()
    {
        $cnic = auth()->user()->cnic;
        $properties = Property::where('cnic', $cnic)->get();
        $status = DB::table('transfer_files')->select('verify_status')->where('user_id', auth()->user()->id)->latest()->first();

        return view('user.propertylist', compact('properties', 'status'));
    }
    public function propertyTracking($id)
{
     $request = Requests::with([
        'transfer',                              // $track
        'transfer.objections',                   // $track->objections (DEO)
        'transfer.objections.responses',
        'transfer.objections.responses.attachments',
        'hdmObjections',                         // $request->hdmObjections (type 4)
        'hdmObjections.responses',
        'hdmObjections.responses.attachments',
    ])->findOrFail($id);

    $track = $request->transfer;                 // blade reads $track->type, $track->deo_action etc.

    return view('user.tracking', compact('request', 'track'));



    return view('user.tracking', compact('track'));
}

/**
 * View/Download objection response attachment file
 */
public function viewObjectionFile($fileId)
{
    try {
        $attachment = \App\Models\ObjectionAttachement::findOrFail($fileId);
        $filePath = public_path('uploads/objection-responses/' . $attachment->file_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Determine the MIME type based on file extension
        $ext = strtolower(pathinfo($attachment->file_path, PATHINFO_EXTENSION));
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'txt' => 'text/plain',
        ];

        $mimeType = $mimeTypes[$ext] ?? 'application/octet-stream';

        // Return file for display/download
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $attachment->file_name . '"'
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

/**
 * Submit a new response to an objection (DEO / Record Clerk)
 */
public function submitObjectionReply($objectionId, Request $request)
{
    try {
        $objection = \App\Models\Objection::findOrFail($objectionId);

        $validated = $request->validate([
            'user_reply' => 'required|string|max:2000',
            'attachment_types' => 'nullable|array',
            'attachment_types.*' => 'string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB per file
        ]);

        // Create the response
        $response = \App\Models\ObjectionResponse::create([
            'objection_id' => $objectionId,
            'user_id' => auth()->id(),
            'response_text' => $validated['user_reply'],
            'status' => 'pending', // New responses start as pending
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $type = $validated['attachment_types'][$index] ?? 'Other';
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/objection-responses/'), $fileName);

                \App\Models\ObjectionAttachement::create([
                    'objection_response_id' => $response->id,
                    'document_type' => $type,
                    'file_path' => $fileName,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Your response has been submitted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

/**
 * Edit an existing objection response (only if status is 'pending')
 */
public function editObjectionReply($responseId, Request $request)
{
    try {
        $response = \App\Models\ObjectionResponse::findOrFail($responseId);

        // Check if response status is still pending
        if (strtolower($response->status ?? 'pending') !== 'pending') {
            return redirect()->back()->with('error', 'This response has already been reviewed. You cannot edit it.');
        }

        // Check if parent objection is resolved
        if (strtolower($response->objection->status ?? 'pending') === 'resolved') {
            return redirect()->back()->with('error', 'This objection has been resolved. You cannot edit the response.');
        }

        $validated = $request->validate([
            'user_reply' => 'required|string|max:2000',
            'attachment_types' => 'nullable|array',
            'attachment_types.*' => 'string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Update response text
        $response->update(['response_text' => $validated['user_reply']]);

        // Handle new attachments
        if ($request->hasFile('attachments')) {
            // Optionally delete old attachments, or keep them. Here we add new ones.
            foreach ($request->file('attachments') as $index => $file) {
                $type = $validated['attachment_types'][$index] ?? 'Other';
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/objection-responses/'), $fileName);

                \App\Models\ObjectionAttachement::create([
                    'objection_response_id' => $response->id,
                    'document_type' => $type,
                    'file_path' => $fileName,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Your response has been updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

/**
 * Submit a new response to an HDM objection
 */
public function submitHDMObjectionReply($objectionId, Request $request)
{

    try {
        $objection = \App\Models\Objection::findOrFail($objectionId);
        $validated = $request->validate([
            'user_reply'           => 'required|string|max:2000',
            'attachment_types'     => 'nullable|array',
            'attachment_types.*'   => 'nullable|string',
            'attachments'          => 'nullable|array',
            'attachments.*'        => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // If any attachment file is uploaded, its type must also be selected — and vice versa
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                if ($file && empty($request->input("attachment_types.$index"))) {
                    return back()
                        ->withErrors(["attachment_types.$index" => "Please select a type for attachment #" . ($index + 1)])
                        ->withInput();
                }
            }
        }

        if ($request->filled('attachment_types')) {
            foreach ($request->input('attachment_types') as $index => $type) {
                if ($type && !$request->hasFile("attachments.$index")) {
                    return back()
                        ->withErrors(["attachments.$index" => "Please upload a file for the selected type: '$type'"])
                        ->withInput();
                }
            }
        }

        // Create the response
        $response = \App\Models\ObjectionResponse::create([
            'objection_id' => $objectionId,
            'user_id' => auth()->id(),
            'response_text' => $validated['user_reply'],
            'status' => 'pending',
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $type = $validated['attachment_types'][$index] ?? 'Other';
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/objection-responses/'), $fileName);

                \App\Models\ObjectionAttachement::create([
                    'objection_response_id' => $response->id,
                    'document_type' => $type,
                    'file_path' => $fileName,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Your HDM response has been submitted successfully.');
    } catch (\Exception $e) {
        dd($e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

/**
 * Edit an existing HDM objection response (only if status is 'pending')
 */
public function editHDMObjectionReply($responseId, Request $request)
{
    try {
        $response = \App\Models\ObjectionResponse::findOrFail($responseId);

        // Check if response status is still pending
        if (strtolower($response->status ?? 'pending') !== 'pending') {
            return redirect()->back()->with('error', 'This response has already been reviewed. You cannot edit it.');
        }

        // Check if parent objection is resolved
        if (strtolower($response->objection->status ?? 'pending') === 'resolved') {
            return redirect()->back()->with('error', 'This objection has been resolved. You cannot edit the response.');
        }

        $validated = $request->validate([
            'user_reply' => 'required|string|max:2000',
            'attachment_types' => 'nullable|array',
            'attachment_types.*' => 'string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Update response text
        $response->update(['response_text' => $validated['user_reply']]);

        // Handle new attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $type = $validated['attachment_types'][$index] ?? 'Other';
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/objection-responses/'), $fileName);

                \App\Models\ObjectionAttachement::create([
                    'objection_response_id' => $response->id,
                    'document_type' => $type,
                    'file_path' => $fileName,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Your HDM response has been updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}


}
