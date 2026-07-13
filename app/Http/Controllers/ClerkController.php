<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DummyReceiver;
use App\Models\DummyWitness;
use App\Models\Property;
use App\Models\TransferFile;
use App\Models\TransferAttach;
use App\Models\Requests;
use App\Models\Inheritance;
use App\Models\PropertyDocument;
use App\Models\PropertyStatement;
use App\Models\Objection;
use App\Models\ObjectionResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

class ClerkController extends Controller
{
    public function transferFileList()
    {
        $town = json_decode(auth()->user()->town);

        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to arra
        }
        if (auth()->user()->hasRole('record-clerk')) {

            $properties = Requests::with(['property', 'participants.owner', 'dummyreceiver'])
                ->whereNull('deo_action')
                ->whereIn('town', $town)

                ->get();
        } else {
            $properties = Requests::with(['property', 'participants', 'dummyreceiver'])
                ->whereIn('town_id', $town)
                ->where(function ($query) {
                    $query->whereRaw('id in (select request_id from transfer_attaches)')
                        ->orWhereRaw('id in (select request_id from dummy_receivers)');
                })
                ->get();
        }


        return view('clerk.index', compact('properties'));
    }

    public function acceptedFileList()
    {
        $town = json_decode(auth()->user()->town);



        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to array
        }


        $properties = Requests::with(['property', 'participants'])
            ->whereIn('town', $town)
            ->where('deo_action', 1)
            ->get();

        return view('clerk.index', compact('properties'));
    }
    public function rejectedFileList()
    {
        $town = json_decode(auth()->user()->town);



        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to array
        }
        $properties = Requests::with(['property', 'participants'])
            ->whereIn('town', $town)
            ->where('deo_action', 0)
            ->get();

        return view('clerk.index', compact('properties'));
    }
    public function transferFileDetail($id)
    {
        if (auth()->user()->hasRole('user')) {

            $property = Requests::with(['property', 'participants', 'transfer'])->with('attachment')->where('id', $id)->latest()->first();
        } else {

            $property = Requests::with(['property', 'participants', 'transfer', 'property.owners'])->with('attachment')->where('id', $id)->latest()->first();
        }
        // dd($property->property->owners->map(fn($e) => $e->name));

        if ($property->request_type == 2) {

            return view('clerk.clerkWarassat', compact('property'));
        }

        return view('clerk.Detail', compact('property'));
    }
    public function transferFileAction(Request $request, $id)
    {
        // Objection handling - same for all roles
        if ($request->has('has_objection')) {
            $data = $request->validate([
                'objection_type'    => 'required',
                'objection_remarks' => 'nullable',
                'objection_date'    => 'required',
            ]);

            Objection::create([
                'requests_id'    => $id,
                'raised_by_id'   => auth()->user()->id,
                'raised_by_role' => auth()->user()->roles->pluck('name')->first(),
                'objection_type' => $data['objection_type'],
                'remarks'        => $data['objection_remarks'],
                'objection_date' => $data['objection_date'],
            ]);

            // Role-based redirect after objection
            if (auth()->user()->hasRole('sub-engineer')) {
                return redirect()->route('engineer.pendingRequests')->with('error', 'Objection raised successfully.');
            }

            if (auth()->user()->hasRole('HDM')) {
                return redirect('/hdm/approved-requests')->with('error', 'Objection raised successfully.');
            }

            return redirect('/objection-request-list')->with('error', 'Objection Raised Successfully.');
        }

        // Verify/Action handling - same for all roles
        $data = $request->validate([
            'verify_status' => 'required',
            'remarks'       => 'nullable',
            'date'          => 'required',
        ]);

        // Role-based update
        if (auth()->user()->hasRole('sub-engineer')) {
            Requests::where('id', $id)->update([
                'engineer_status'  => $request->verify_status,
                'engineer_date'    => $data['date'],
                'engineer_remarks' => $data['remarks'],
            ]);
        } elseif (auth()->user()->hasRole('HDM')) {
            Requests::where('id', $id)->update([
                'head_status'  => $request->verify_status,
                'head_date'    => $data['date'],
                'head_remarks' => $data['remarks'],
            ]);
        } else {
            Requests::where('id', $id)->update([
                'deo_action'  => $request->verify_status == 'Yes' ? 1 : 0,
                'deo_date'    => $data['date'],
                'deo_id'      => auth()->user()->id,
                'deo_remarks' => $data['remarks'],
            ]);
        }

        // Role-based redirect after action
        if (auth()->user()->hasRole('sub-engineer')) {
            return redirect()->route('engineer.pendingRequests')->with('success', 'Status Updated Successfully.');
        }

        if (auth()->user()->hasRole('HDM')) {
            return redirect('/hdm/approved-requests')->with('success', 'Status Updated Successfully.');
        }

        return redirect('/transfer-request-file')->with('success', 'Status Updated Successfully.');
    }

    public function fileQA()
    {

        $town = json_decode(auth()->user()->town);

        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to array
        }

        $data = DB::table('properties')
            ->select(
                'properties.id',
                'properties.code',
                'properties.plot_no',
                'properties.center',
                'towns.name as town', // 👈 get town name from joined table
                'properties.sector'
            )
            ->leftJoin('towns', 'towns.id', '=', 'properties.town')
            ->whereIn('town', $town)
            ->whereNull('status')
            ->orderByRaw('CAST(plot_no AS UNSIGNED) ASC')
            ->get();

        $heading = 'Properties List';
        return view('qa.mdhaqalist', compact('data', 'heading'));
    }
    public function Qafile(Request $request)
    {
        $qaId = $request->qa_id;
        $status = $request->status;


        $town = json_decode(auth()->user()->town);
        if (!is_array($town)) {
            $town = [$town];
        }


        $query = DB::table('properties')
            ->select(
                'properties.id',
                'properties.code',
                'properties.plot_no',
                'properties.center',
                'towns.name as town',
                'properties.sector',
                'properties.locality',
                'properties.category',
                'properties.qa_id',
                'properties.status'
            )
            ->leftJoin('towns', 'towns.id', '=', 'properties.town')
            ->whereNotNull('properties.status')
            ->whereNull('properties.resolved');

        // ✅ Apply town filter only if no qa_id is passed
        if (!$qaId) {
            $query->whereIn('properties.town', $town);
        }


        // ✅ Apply qa_id filter if present
        if ($qaId) {
            $query->where('properties.qa_id', $qaId);
        }

        // ✅ Apply status filter if present
        if ($status) {
            $query->where('properties.status', $status);
        }

        $data = $query->get();


        return view('clerk.filelist', compact('data', 'qaId', 'status'));
    }



    public function storeQA(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);


        $dat = [];
        $dat['status'] = $request->status;
        $dat['remarks'] = $request->remarks;
        // Role: record-clerk
        if (auth()->user()->hasRole('record-clerk')) {
            $dat['qa_id'] = auth()->user()->id;
        }

        // Role: mdhaQA
        if (auth()->user()->hasRole('mdhaQA') && $request->status == 'No Error') {
            $dat['resolved'] = 1;
        }

        $data = Property::where('id', $request->property)->update($dat);
        session()->flash('success', 'File QA is done Successfully.');

        return redirect()->route('Qafiles');
    }

    public function transferFileAttachements()
    {


        $properties = Requests::with(['property', 'participants'])
            ->whereRaw('id not in (select request_id from transfer_attaches)')
            ->whereNotNull('appointment')
            ->orderBy('appointment_no', 'asc')
            ->orderBy('appointment_date', 'asc')
            ->get();



        $type = 1;

        return view('clerk.documnetuploadlist', compact('properties', 'type'));
    }

    public function transferFileAttach($id)
    {


        $data = Requests::where('id', $id)->select('town', 'property_id', 'id')->first();

        return view('clerk.docattachement', compact('data'));
    }
    public function transferFileAttachDone(Request $request)
    {


        // Attachments except 'other'
        $attachments = [
            'transferfee_attach',
            'klc_attach',
            'incometax_attach',
            'educess_attach',
            'stampduty_attach', // special case
        ];

        // Validation rules
        $rules = [
            'other' => 'nullable|file', // Other document can be null
        ];

        foreach ($attachments as $field) {
            $rules[$field] = 'nullable|file';
            $rules[$field . '_paid_amount'] = 'nullable|numeric|required_with:' . $field;
            $rules[$field . '_paid_date']   = 'nullable|date|required_with:' . $field;

            // Challan / stamp field
            if ($field === 'stampduty_attach') {
                $rules['stamp_no'] = 'nullable|string|required_with:' . $field;
            } else {
                $rules[$field . '_challan_no'] = 'nullable|string|required_with:' . $field;
            }
        }

        $validated = $request->validate($rules);

        $storedFiles = [];
        $allFiles = array_merge($attachments, ['other']);

        // Store uploaded files
        foreach ($allFiles as $field) {
            $storedFiles[$field] = null;

            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path("uploads/{$field}/"), $filename);
                $storedFiles[$field] = $filename;
            }
        }

        // Prepare data for DB
        $attachData = [
            'request_id'  => $request->request_id,                // replace with dynamic value
            'user_id'     => auth()->id(),
            'property_id' => $request->property_id,              // replace with dynamic value
            'town_id'     => $request->town_id,                // replace with dynamic value
            'other'       => $storedFiles['other'],
        ];

        foreach ($attachments as $field) {
            $prefix = str_replace('_attach', '', $field);

            $attachData[$field] = $storedFiles[$field];
            $attachData[$prefix . '_paid_amount'] = $request->input($field . '_paid_amount');
            $attachData[$prefix . '_paid_date']   = $request->input($field . '_paid_date');

            // Handle challan / stamp field
            if ($field === 'stampduty_attach') {
                $attachData['stamp_no'] = $request->input('stamp_no');
            } else {
                $attachData[$prefix . '_challan_no'] = $request->input($field . '_challan_no');
            }
        }

        $attach = TransferAttach::create($attachData);

        return redirect('/transfer-files-list')->with('success', 'Attachments Uploaded Successfully.');
    }

    public function scheduleAppointment()
    {
        $town = json_decode(auth()->user()->town);

        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to array
        }
        if (auth()->user()->hasRole('record-clerk')) {

            $properties = Requests::with(['property', 'participants.owner'])
                ->where('deo_action', 1)
                ->whereNull('appointment')
                ->whereIn('town', $town)
                ->get();
        }

        $type = 2;
        return view('clerk.appointmentlist', compact('properties', 'type'));
    }

    public function saveAppointment(Request $request)
    {
        try {
            $request->validate([
                'request_id' => 'required|exists:requests,id',
                'appointment' => 'required|date'
            ]);

            $appointmentDate = \Carbon\Carbon::parse($request->appointment);
            $countForDay = DB::table('requests')
                ->whereDate('appointment_date', $appointmentDate->toDateString())
                ->count();

            // New appointment number for the date
            $appointmentNumber = $countForDay + 1;
            DB::table('requests')->updateOrInsert(
                ['id' => $request->request_id],
                [
                    'appointment_date' => $request->appointment,
                    'appointment_no' => $appointmentNumber,
                    'appoint_add' => now()->format('Y-m-d'),
                    'appointment' => 1,
                ]
            );

            return response()->json(['message' => 'Appointment saved successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    public function appointmentList()
    {
        $town = json_decode(auth()->user()->town);

        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to array
        }
        if (auth()->user()->hasRole('record-clerk')) {

            $properties = Requests::with(['property', 'property.owners'])
                ->where('deo_action', 1)
                ->whereNotNull('appointment')
                ->whereIn('town', $town)
                ->get();
        }
        $type = 1;

        return view('clerk.appointmentlist', compact('properties', 'type'));
    }
    public function reScheduleAppoitment()
    {
        $town = json_decode(auth()->user()->town);

        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to array
        }
        if (auth()->user()->hasRole('record-clerk')) {

            $properties = Requests::with(['property', 'property.owners'])
                ->where('deo_action', 1)
                ->whereNotNull('appointment')
                ->whereIn('town', $town)
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereDate('appointment_date', '<', Carbon::today())
                            ->whereNull('dd_action');
                    });
                })
                ->get();

            $type = 2;
        }

        return view('clerk.appointmentlist', compact('properties', 'type'));
    }

    public function attachedfilelist()
    {

        $properties = Requests::with(['property', 'participants'])
            ->whereHas('transferAttaches', function ($q) {
                $q->where('status', null);
            })
            ->whereDoesntHave('dummywitness')
            ->orderBy('appointment_no')
            ->orderBy('appointment_date')
            ->get();




        $type = 2;

        return view('clerk.documnetuploadlist', compact('properties', 'type'));
    }

    public function receiverDetail($id)
    {
        $owner = Requests::with(['transfer', 'participants', 'dummyreceiver'])->where('id', $id)->first();

        return view('clerk.transferPropertyDetail', compact('id', 'owner'));
    }
    public function receiverDetailDone(Request $request, $id)
    {


        DB::beginTransaction();

        try {
            // ✅ 1. Validate the request
            $validated = $request->validate([
                'receivers.*.name'         => 'required|string|max:255',
                'receivers.*.father_name'  => 'required|string|max:255',
                'receivers.*.cnic'  => 'required',
                'receivers.*.address'  => 'required',
                'receivers.*.cnic_front'   => 'nullable',
                'receivers.*.cnic_back'    => 'nullable',

                'witness.*.name'           => 'required|string|max:255',
                'witness.*.father_name'    => 'required|string|max:255',
                'witness.*.cnic'           => 'required',
                'witness.*.cnic_front'     => 'required|file|mimes:jpg,jpeg,png|max:5129',
                'witness.*.cnic_back'      => 'required|file|mimes:jpg,jpeg,png|max:5129',

                'head_status'     => 'required',
                'head_date'     => 'required',

            ]);


            foreach ($request->requester as $requester) {

                $name = preg_replace('/\s+/', '_', strtolower($requester['name']));
                $uniqueId = Str::random(5);
                if (!empty($requester['cnic_front']) && $requester['cnic_front'] instanceof \Illuminate\Http\UploadedFile) {
                    $cnicFrontFile = $requester['cnic_front'];
                    $cnicFrontFilename = $name . '_cnic_front_' . $uniqueId . '.' . $cnicFrontFile->getClientOriginalExtension();
                    $cnicFrontFile->move(public_path('uploads/user/cnics/'), $cnicFrontFilename);
                    $cnicFrontPath = $cnicFrontFilename;
                } else {
                    $cnicFrontPath = $requester['cnic_front'] ?? null; // Keep existing if not re-uploaded

                }

                // ✅ Handle CNIC Back File
                if (!empty($requester['cnic_back']) && $requester['cnic_back'] instanceof \Illuminate\Http\UploadedFile) {
                    $cnicBackFile = $requester['cnic_back'];
                    $cnicBackFilename = $name . '_cnic_back_' . $uniqueId . '.' . $cnicBackFile->getClientOriginalExtension();
                    $cnicBackFile->move(public_path('uploads/user/cnics/'), $cnicBackFilename);
                    $cnicBackPath = $cnicBackFilename;
                } else {
                    $cnicBackPath = $requester['cnic_back'] ?? null;
                }



                Inheritance::where('id', $requester['id'])->update([
                    'address' => $requester['address'],
                    'cnic_back' => $cnicBackPath,
                    'cnic_front' => $cnicFrontPath,
                ]);
            }


            // ✅ 2. Store Receivers
            foreach ($request->receivers as $receiver) {
                $name = preg_replace('/\s+/', '_', strtolower($receiver['name']));
                $uniqueId = Str::random(5);

                if (isset($receiver['cnic_front']) && $receiver['cnic_front'] instanceof \Illuminate\Http\UploadedFile) {
                    dump('front');
                    $cnicFrontFile = $receiver['cnic_front'];
                    $cnicFrontFilename = $name . '_cnic_front_' . $uniqueId . '.' . $cnicFrontFile->getClientOriginalExtension();
                    $cnicFrontFile->move(public_path('uploads/user/cnics/'), $cnicFrontFilename);
                    $cnicFrontPath = $cnicFrontFilename;
                } else {
                    $cnicFrontPath = $receiver['cnic_front']; // or keep old value if updating
                }


                if (isset($receiver['cnic_back']) && $receiver['cnic_back'] instanceof \Illuminate\Http\UploadedFile) {
                    $cnicBackFile = $receiver['cnic_back'];
                    $cnicBackFilename = $name . '_cnic_back_' . $uniqueId . '.' . $cnicBackFile->getClientOriginalExtension();
                    $cnicBackFile->move(public_path('uploads/user/cnics/'), $cnicBackFilename);
                    $cnicBackPath = $cnicBackFilename;
                } else {
                    $cnicBackPath = $receiver['cnic_back'];
                }

                DummyReceiver::updateOrCreate(
                    ['id' => $receiver['id'] ?? null], // Unique identifier to find the record
                    [                                  // Values to update or create
                        'request_id'  => $id,
                        'name'        => $receiver['name'],
                        'father_name' => $receiver['father_name'],
                        'cnic'        => $receiver['cnic'],
                        'area'        => $receiver['area'],
                        'address'     => $receiver['address'],
                        'cnic_front'  => $cnicFrontPath,
                        'cnic_back'   => $cnicBackPath,
                    ]
                );
            }

            // ✅ 3. Store Witnesses
            foreach ($request->witness as $witness) {
                $name = preg_replace('/\s+/', '_', strtolower($witness['name']));
                $uniqueId = Str::random(5);

                $cnicFrontFile = $witness['cnic_front'];
                $cnicFrontFilename = $name . '_cnic_front_' . $uniqueId . '.' . $cnicFrontFile->getClientOriginalExtension();
                $cnicFrontFile->move(public_path('uploads/user/cnics/'), $cnicFrontFilename);
                $cnicFrontPath =  $cnicFrontFilename;

                $cnicBackFile = $witness['cnic_back'];
                $cnicBackFilename = $name . '_cnic_back_' . $uniqueId . '.' . $cnicBackFile->getClientOriginalExtension();
                $cnicBackFile->move(public_path('uploads/user/cnics/'), $cnicBackFilename);
                $cnicBackPath = $cnicBackFilename;

                DummyWitness::create([
                    'request_id' => $id,
                    'name'        => $witness['name'],
                    'father_name' => $witness['father_name'],
                    'cnic'        => $witness['cnic'],
                    'address'        => $witness['address'],
                    'cnic_front'  => $cnicFrontPath,
                    'cnic_back'   => $cnicBackPath,
                ]);
            }


            Requests::where('id', $id)->update([
                'head_status' => $request->head_status,
                'head_date' => $request->head_date,
                'head_remarks' => $request->head_remarks,
            ]);



            DB::commit();
            return redirect()->route('attachedFileList')->with(['message' => 'Data stored successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addedDetailFiles()
    {
        $properties = Requests::with(['property', 'participants'])
            ->whereHas('transferAttaches', function ($q) {
                $q->where('status', null);
            })
            ->whereHas('dummyreceiver')
            ->orderBy('appointment_no')
            ->orderBy('appointment_date')
            ->get();

        $type = 3;
        return view('clerk.documnetuploadlist', compact('properties', 'type'));
    }

    public function addedDetailEdit($id)
    {
        $owner = Requests::with(['participants', 'dummyreceiver', 'dummywitness'])->where('id', $id)->first();

        return view('clerk.transferPropertyDetailEdit', compact('owner', 'id'));
    }

    public function receiverDetailUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // ✅ 1. Validate the request
            $validated = $request->validate([
                'receivers.*.name'         => 'required|string|max:255',
                'receivers.*.father_name'  => 'required|string|max:255',
                'receivers.*.cnic_front'   => '',
                'receivers.*.cnic_back'    => '',

                'witness.*.name'           => 'required|string|max:255',
                'witness.*.father_name'    => 'required|string|max:255',
                'witness.*.cnic'           => 'required',
                'witness.*.cnic_front'     => '',
                'witness.*.cnic_back'      => '',
            ]);


            // ✅ 2. Store Receivers
            foreach ($request->receivers as $key => $receiver) {
                $cnicFrontPath = $receiver['cnic_front'] ?? null;
                $cnicBackPath = $receiver['cnic_back'] ?? null;

                // Handle file uploads
                $cnicFrontFile = $request->file("receivers.$key.cnic_front");
                $cnicBackFile = $request->file("receivers.$key.cnic_back");

                $name = preg_replace('/\s+/', '_', strtolower($receiver['name']));
                $uniqueId = Str::random(5);

                if ($cnicFrontFile) {
                    $cnicFrontFilename = $name . '_cnic_front_' . $uniqueId . '.' . $cnicFrontFile->getClientOriginalExtension();
                    $cnicFrontFile->move(public_path('uploads/user/cnics/'), $cnicFrontFilename);
                    $cnicFrontPath = $cnicFrontFilename;
                }

                if ($cnicBackFile) {
                    $cnicBackFilename = $name . '_cnic_back_' . $uniqueId . '.' . $cnicBackFile->getClientOriginalExtension();
                    $cnicBackFile->move(public_path('uploads/user/cnics/'), $cnicBackFilename);
                    $cnicBackPath = $cnicBackFilename;
                }

                if (!empty($receiver['id'])) {
                    // Update existing
                    $dummyReceiver = DummyReceiver::find($receiver['id']);
                    if ($dummyReceiver) {
                        $dummyReceiver->update([
                            'request_id'  => $id,
                            'name'        => $receiver['name'],
                            'father_name' => $receiver['father_name'],
                            'cnic'        => $receiver['cnic'],
                            'address'        => $receiver['address'],
                            'area'        => $receiver['area'],
                            'cnic_front'  => $cnicFrontPath,
                            'cnic_back'   => $cnicBackPath,
                        ]);
                    }
                } else {
                    // Create new
                    DummyReceiver::create([
                        'request_id'  => $id,
                        'name'        => $receiver['name'],
                        'father_name' => $receiver['father_name'],
                        'cnic'        => $receiver['cnic'],
                        'address'        => $receiver['address'],
                        'area'        => $receiver['area'],
                        'cnic_front'  => $cnicFrontPath,
                        'cnic_back'   => $cnicBackPath,
                    ]);
                }
            }

            // ✅ 3. Store Witnesses
            foreach ($request->witness as $key => $witness) {
                $cnicFrontPath = $witness['cnic_front'] ?? null;
                $cnicBackPath = $witness['cnic_back'] ?? null;

                $cnicFrontFile = $request->file("witness.$key.cnic_front");
                $cnicBackFile = $request->file("witness.$key.cnic_back");

                $name = preg_replace('/\s+/', '_', strtolower($witness['name']));
                $uniqueId = Str::random(5);

                if ($cnicFrontFile) {
                    $cnicFrontFilename = $name . '_cnic_front_' . $uniqueId . '.' . $cnicFrontFile->getClientOriginalExtension();
                    $cnicFrontFile->move(public_path('uploads/user/cnics/'), $cnicFrontFilename);
                    $cnicFrontPath = $cnicFrontFilename;
                }

                if ($cnicBackFile) {
                    $cnicBackFilename = $name . '_cnic_back_' . $uniqueId . '.' . $cnicBackFile->getClientOriginalExtension();
                    $cnicBackFile->move(public_path('uploads/user/cnics/'), $cnicBackFilename);
                    $cnicBackPath = $cnicBackFilename;
                }

                if (!empty($witness['id'])) {
                    $dummyWitness = DummyWitness::find($witness['id']);
                    if ($dummyWitness) {
                        $dummyWitness->update([
                            'request_id'  => $id,
                            'name'        => $witness['name'],
                            'father_name' => $witness['father_name'],
                            'cnic'        => $witness['cnic'],
                            'address'        => $witness['address'],
                            'cnic_front'  => $cnicFrontPath,
                            'cnic_back'   => $cnicBackPath,
                        ]);
                    }
                } else {
                    DummyWitness::create([
                        'request_id'  => $id,
                        'name'        => $witness['name'],
                        'father_name' => $witness['father_name'],
                        'cnic'        => $witness['cnic'],
                        'address'        => $witness['address'],
                        'cnic_front'  => $cnicFrontPath,
                        'cnic_back'   => $cnicBackPath,
                    ]);
                }
            }

            Requests::where('id', $id)->update([
                'head_status' => $request->head_status,
                'head_date' => $request->head_date,
                'head_remarks' => $request->head_remarks,
            ]);
            DB::commit();
            return redirect()->route('addedDetailFiles')->with(['message' => 'Data stored successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteDummyUser($id, $type)
    {
        try {
            if ($type == 1) {
                $receiver = DummyReceiver::findOrFail($id);
                $receiver->delete();
            } else {
                $witness = DummyWitness::findOrFail($id);
                $witness->delete();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function addedDetails($id)
    {
        $owner = Requests::with(['propertyowner', 'dummyreceiver', 'dummywitness'])->where('id', $id)->first();

        return view('clerk.transsferPropertyDetail', compact('owner', 'id'));
    }

    public function requesterStatement($id, $type)
    {

        if ($type == 1  || $type == 2 || $type == 3) {
            $data = TransferFile::with(['callRepresentative', 'callAttorney'])->where('request_id', $id)->first();



            $property = Property::with([
                'township',
                'owners' => function ($query) {
                    $query->where('is_current', 1);
                },
            ])->where('id', $data->property_id)->first();

            $request = Requests::with(['dummyreceiver', 'dummywitness', 'participants.owner', 'participants.representative'])->where('id', $id)->first();
            $previous = DB::table('requests')
                ->where('property_id', $data->property_id)
                ->where('id', '<', $id)
                ->whereIn('request_type', [1, 2, 3])
                ->orderBy('id', 'desc')
                ->pluck('request_type')
                ->first();

            $receiver = $request->dummyreceiver->pluck('cnic')->toArray();
            $ownersNotReceivers = [];
            $i = 0;

            foreach ($request->property->owners as $key => $owner) {
                if (!in_array($owner->cnic, $receiver)) {
                    $ownersNotReceivers[$i]['name'] = $owner->name;
                    $ownersNotReceivers[$i]['father_name'] = $owner->father_name;
                    $previousOwner[] = $owner->cnic;
                    $i++;
                }
            }


            $ownersWhoMadeRequest = [];
            foreach ($request->participants as $participant) {
                $ownersWhoMadeRequest[] = $participant->owner->cnic; // or ->cnic
            }

            if (empty(array_diff($previousOwner, $ownersWhoMadeRequest))) {
                // All owners have made requests
                $allOwnersMadeRequest = true;
            } else {
                // Some owners have not made requests
                $allOwnersMadeRequest = false;
            }
            $singleOwner = count($previousOwner) > 1 ? false : true;
            $multipleRequest = count($ownersWhoMadeRequest) > 1 ? true : false;
        }

        switch ($type) {
            case 1:
                if (!is_null($data->any_attorney) && is_null($data->shared_attorney)) {


                    return view(
                        'clerk.drafts.sellerWithAttorney',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                } elseif (!is_null($data->any_attorney) && !is_null($data->shared_attorney)) {
                    return view(
                        'clerk.drafts.sellerWithAttorney',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                } elseif (is_null($data->any_attorney) && is_null($data->shared_attorney)) {

                    return view(
                        'clerk.drafts.sellerStatement',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                }

                return view('clerk.drafts.sellerStatement', compact('data', 'property', 'request', 'type', 'previous', 'singleOwner', 'multipleRequest', 'allOwnersMadeRequest'));
                break;

            case 2:
                return view('clerk.drafts.warssatStatement',  compact('data', 'property', 'request', 'type', 'previous', 'singleOwner', 'multipleRequest', 'allOwnersMadeRequest'));
                break;
            case 3:
                if (!is_null($data->any_attorney) && is_null($data->shared_attorney)) {


                    return view(
                        'clerk.drafts.sellerWithAttorney',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                } elseif (!is_null($data->any_attorney) && !is_null($data->shared_attorney)) {
                    return view(
                        'clerk.drafts.shareAttorney',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                } elseif (is_null($data->any_attorney) && is_null($data->shared_attorney)) {

                    return view(
                        'clerk.drafts.sellerStatement',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                }
        }
    }

    public function requesterStatementStore(Request $request, $id)
    {


        $rules = [];

        if ($request->has('type') && $request->type == 'transferOrder') {

            $rules['transfer_order'] = 'required';
            $rules['nakle_bala'] = 'required';
        } else {

            $rules['requester_statement'] = 'required';
            if ($request->request_type != 2) {
                $rules['witness_statement'] = 'required';
            }
        }

        // dd($request->all());
        $request->validate($rules);


        try {
            $updateData = [];

            if ($request->type == 'transferOrder') {
                $updateData['transfer_order'] = $request->transfer_order;
                $updateData['nakle_bala']     = $request->nakle_bala;
            } else {
                $updateData['requester_statement'] = $request->requester_statement;
                $updateData['witness_statement'] = $request->witness_statement;
            }

            PropertyStatement::updateOrCreate(
                ['request_id' => $id],
                $updateData
            );

            if (auth()->user()->hasRole('assistant-director')) {
                return redirect('/transfer-order-statement')->with('success', 'ڈیٹا کامیابی سے محفوظ ہو گیا ہے۔');
            }
            return redirect('/added-detail-files')->with('success', 'ڈیٹا کامیابی سے محفوظ ہو گیا ہے۔');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'خرابی: ' . $e->getMessage());
        }
    }

    public function receiverStatement($id, $type)
    {
        if ($type == 1  || $type == 2 || $type == 3) {
            $data = TransferFile::with(['callRepresentative', 'callAttorney'])->where('request_id', $id)->first();



            $property = Property::with([
                'township',
                'owners' => function ($query) {
                    $query->where('is_current', 1);
                },
            ])->where('id', $data->property_id)->first();

            $request = Requests::with(['dummyreceiver', 'dummywitness', 'participants.owner', 'participants.representative'])->where('id', $id)->first();
            $previous = DB::table('requests')
                ->where('property_id', $data->property_id)
                ->where('id', '<', $id)
                ->whereIn('request_type', [1, 2, 3])
                ->orderBy('id', 'desc')
                ->pluck('request_type')
                ->first();

            $receiver = $request->dummyreceiver->pluck('cnic')->toArray();
            $ownersNotReceivers = [];
            $i = 0;

            foreach ($request->property->owners as $key => $owner) {
                if (!in_array($owner->cnic, $receiver)) {
                    $ownersNotReceivers[$i]['name'] = $owner->name;
                    $ownersNotReceivers[$i]['father_name'] = $owner->father_name;
                    $previousOwner[] = $owner->cnic;
                    $i++;
                }
            }

            $ownersWhoMadeRequest = [];
            foreach ($request->participants as $participant) {
                $ownersWhoMadeRequest[] = $participant->owner->cnic; // or ->cnic
            }

            if (empty(array_diff($previousOwner, $ownersWhoMadeRequest))) {
                // All owners have made requests
                $allOwnersMadeRequest = true;
            } else {
                // Some owners have not made requests
                $allOwnersMadeRequest = false;
            }
            $singleOwner = count($previousOwner) > 1 ? false : true;
            $multipleRequest = count($ownersWhoMadeRequest) > 1 ? true : false;
        }

        switch ($type) {
            case 1:
                if ($data->representative == 'self') {

                    return view(
                        'clerk.drafts.receiverStatement',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                } else {
                    return view(
                        'clerk.drafts.receiverWithRepresentative',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                }

            case 2:
                return view('clerk.drafts.warssatBuyerStatement', compact(
                    'request',
                    'property',
                    'data',
                    'type',
                    'previous',
                    'singleOwner',
                    'multipleRequest',
                    'allOwnersMadeRequest'
                ));
                break;
            case 3:
                if ($data->representative == 'self') {

                    return view(
                        'clerk.drafts.receiverStatement',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                } else {
                    return view(
                        'clerk.drafts.receiverWithRepresentative',
                        compact(
                            'request',
                            'property',
                            'data',
                            'type',
                            'previous',
                            'singleOwner',
                            'multipleRequest',
                            'allOwnersMadeRequest'
                        )
                    );
                }
        }
    }

    public function receiverStatementStore(Request $request, $id)
    {
        $request->validate([
            'requester_statement' => 'required',
        ]);

        try {

            PropertyStatement::updateOrCreate(
                [
                    'request_id' => $id,
                ],
                [

                    'receiver_statement' => $request->requester_statement,

                ]
            );

            return redirect('/added-detail-files')->with('success', 'statement submit successfully.');
        } catch (\Exception $e) {
            // کسی خرابی کی صورت میں میسج دکھانا
            return redirect()->back()->with('error', 'خرابی: ' . $e->getMessage());
        }
    }

    public function viewTransferOrder($id)
    {

        $document = PropertyDocument::where('request_id', $id)->latest()->first();

        return view('viewTransferOrder', compact('document'));
    }
    public function objectionFileList()
    {
        $town = json_decode(auth()->user()->town);

        if (!is_array($town)) {
            $town = [$town]; // Convert single digit to array
        }
        if (auth()->user()->hasRole('record-clerk')) {

            $properties = Requests::with(['property', 'property.owners', 'objections']) // Eager load objections
                ->whereIn('town', $town)

                // Filter for Record Clerk objections
                ->whereHas('objections', function ($query) {
                    $query->where('raised_by_role', 'record-clerk');
                })
                ->get();
        }
        $type = 4;

        return view('clerk.objectionRequestList', compact('properties', 'type'));
    }

    public function objectionRequestDetail($id)
    {
        try {
            $request = Requests::with(['property', 'participants.owner'])->where('id', $id)->get();
            // dd($request);
            $objection = Objection::with('responses')->where('requests_id', $id)->first();

            return view('clerk.objectionRequestEdit', compact('objection', 'request'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect('/objection-request-list')->with('error', 'Objection not found');
        }
    }

    public function updateObjection(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'objection_type' => 'required|string',
                'objection_date' => 'required|date',
                'remarks' => 'nullable|string',
                'status' => 'nullable|string',
            ]);

            $objection = Objection::findOrFail($id);
            $objection->update([
                'objection_type' => $validated['objection_type'],
                'objection_date' => $validated['objection_date'],
                'remarks' => $validated['remarks'],
                'status' => $validated['status'] ?? $objection->status,
            ]);

            return redirect('/objection-request-list')->with('success', 'Objection updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating objection: ' . $e->getMessage());
        }
    }

    public function updateResponseAuthorityStatus(Request $request, $id)
    {

        try {
            // 1. Validation: 'remarks' is mandatory only when 'not_satisfactory'
            $validated = $request->validate([
                'response_authority_status' => 'required|string',
                'remarks' => $request->response_authority_status == 'not-satisfactory' ? 'required|string' : 'nullable|string',
            ]);

            $currentResponse = ObjectionResponse::findOrFail($id);

            // 2. Ensure only the person who raised the objection can review the reply
            if ($currentResponse->objection->raised_by_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized: Only the officer who raised this objection can review it.');
            }

            // 3. Update the user's specific reply status

            $currentResponse->update([
                'status' => $validated['response_authority_status'],
                'authority_remarks' => $validated['remarks'],
            ]);

            $message = $validated['response_authority_status'] == 'not-satisfactory'
                ? 'Response marked as not satisfactory. User has been notified.'
                : 'Response marked as satisfactory.';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateResponseStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string|in:pending,satisfactory,not-satisfactory,dismissed',
                'authority_remarks' => 'nullable|string',
            ]);

            $response = ObjectionResponse::findOrFail($id);

            $response->update([
                'status' => $validated['status'],
                'authority_remarks' => $validated['authority_remarks'] ?? $response->authority_remarks,
            ]);

            $message = match ($validated['status']) {
                'satisfactory' => 'Response marked as Satisfactory ✓',
                'not-satisfactory' => 'Response marked as Not Satisfactory ✗',
                'dismissed' => 'Response dismissed',
                default => 'Response status updated'
            };

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function deleteObjection(Request $request, $id)
    {
        try {
            $objection = Objection::findOrFail($id);
            $requestId = $objection->requests_id;

            // Delete all objection responses and their attachments
            if ($objection->responses) {
                foreach ($objection->responses as $response) {
                    // Delete attachments associated with this response
                    if ($response->attachments) {
                        foreach ($response->attachments as $attachment) {
                            // Delete the file if it exists
                            if ($attachment->file_path && file_exists(public_path($attachment->file_path))) {
                                unlink(public_path($attachment->file_path));
                            }
                            $attachment->delete();
                        }
                    }
                    $response->delete();
                }
            }

            // Delete the objection itself
            $objection->delete();

            return redirect("/objection-request-detail/$requestId")->with('success', 'Objection and its responses have been deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting objection: ' . $e->getMessage());
        }
    }
}
