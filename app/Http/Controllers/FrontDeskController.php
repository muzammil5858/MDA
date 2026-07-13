<?php

namespace App\Http\Controllers;

use App\Models\Inheritance;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Property;
use App\Models\TransferFile;
use App\Models\Requests;
use App\Models\Representative;
use App\Models\DummyReceiver;
use App\Models\RequestParticipents;
use App\Models\SmallRequest;
use DB;
use Exception;

class FrontDeskController extends Controller
{
    public function createuser(){
        $roles = Role::pluck('name','name')->all();

        return view('desk.createuser',compact('roles'));
    }

    public function index(){
        $users = User::where('source','like','%'.auth()->user()->id)->get();

        return view('desk.userslist',compact('users'));
    }
    public function edituser($id){
         $user = User::find($id);

        $roles = Role::pluck('name','name')->all();

        $userRole = $user->roles->pluck('name','name')->all();

        return view('desk.edituser',compact('user','roles','userRole'));
    }

    public function propertyVerify(Request $request){
        try {
            $properties = Property::where('code',$request->code)->with('township')->get();

            return response()->json([
            'exists' => $properties->isNotEmpty(),
            'message' => $properties->isNotEmpty() ? 'Properties retrieved successfully' : 'No properties found',
            'properties' => $properties->map(function ($property) {
                return [
                    'code' => $property->code ?? '-',
                    'plot_no' => $property->plot_no ?? '-',
                    'category' => $property->category ?? '-',
                    'town' => $property->township ? $property->township->name : '-',
                    'sector' => $property->sector ?? '-',
                    'id' => $property->id ?? '-'
                ];
            })->toArray()
        ]);
        } catch (\Exception $e) {
            \Log::error('Property Verify Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'code' => $request->code
            ]);

            return response()->json([
                'exists' => false,
                'message' => 'Error fetching properties',
                'properties' => []
            ], 500);
        }

    }
    public function TransferFilestore(Request $request, $id)
    {
        // dd($request->all());

        if($request->request_type == 2){
            return $this->warassatStore($request,$id);
        }
       $rules = [
        'request_type' => 'required',
        'town' => 'required',
        'sector' => 'required',
        'sold_price' => 'required',

        // Multi-buyer basic validation
        'buyers' => 'required|array|min:1',
        'buyers.*.name' => 'required|string',
        'buyers.*.fname' => 'required|string',
        'buyers.*.cnic' => 'required|string',

        // Shared Representative validation (only if checked)
        'shared_rep_check' => 'nullable',
        'buyers.*.mode' => 'required_without:shared_rep_check|in:self,representative',
        'shared_representative.name' => 'required_if:shared_rep_check,1',
        'shared_representative.cnic' => 'required_if:shared_rep_check,1',
        'shared_representative.address' => 'required_if:shared_rep_check,1',
        'shared_representative.phone' => 'required_if:shared_rep_check,1',
        'shared_representative.rep_attorney_letter' => 'required_if:shared_rep_check,1',
        'shared_representative.rep_cnic_front' => 'required_if:shared_rep_check,1',
        'shared_representative.rep_cnic_back' => 'required_if:shared_rep_check,1',
    ];




// Seller validations
// Seller validations
if ($request->has('seller_request')) {
    foreach ($request->seller_request as $sellerId) {
        // Seller mode self or attorney
        $mode = $request->seller_mode[$sellerId] ?? null;

        // Always require seller_mode itself
        $rules["seller_mode.$sellerId"] = 'required|in:self,attorney';

        // If seller mode is attorney
        if ($mode === 'attorney') {
            // Check if shared attorney is enabled
            if (!$request->has('shared_attorney_check')) {
                // Personal attorney required only when NO shared attorney
                $rules = array_merge($rules, [
                    "attorney.$sellerId.name"        => 'required|string',
                    "attorney.$sellerId.father_name" => 'required|string',
                    "attorney.$sellerId.cnic"        => 'required|string',
                    "attorney.$sellerId.phone"       => 'required|string',
                    "attorney.$sellerId.address"     => 'required|string',
                    "attorney.$sellerId.attorney_letter" => 'required|file',
                    "attorney.$sellerId.cnic_front"  => 'required|file',
                    "attorney.$sellerId.cnic_back"   => 'required|file',
                ]);
            }
        }
    }
}

// Shared attorney check
if ($request->has('shared_attorney_check')) {
    $rules['shared_attorney_check'] = 'required|boolean';

    $rules = array_merge($rules, [
        "shared_attorney.name"        => 'required|string',
        "shared_attorney.father_name" => 'required|string',
        "shared_attorney.cnic"        => 'required|string',
        "shared_attorney.phone"       => 'required|string',
        "shared_attorney.address"     => 'required|string',
        "shared_attorney.attorney_letter" => 'required|file',
        "shared_attorney.cnic_front"  => 'required|file',
        "shared_attorney.cnic_back"   => 'required|file',
    ]);
}


// Finally validate
$validated = $request->validate($rules);

           try {
        DB::beginTransaction();

        if ($request->has('seller_request')) {
            if($request->owners){

                foreach ($request->owners as $index => $sellerId) {


                // Check if this owner uploaded CNIC front or back
                $hasFront = $request->hasFile("owners.{$index}.cnic_front");
                $hasBack  = $request->hasFile("owners.{$index}.cnic_back");

        $pathback = null;
        $pathfront = null;
        if ($hasFront) {
            $file = $request->file("owners.{$index}.cnic_front");
            $pathfront = $this->uploadRepresentativeFile($file, 'uploads/user/cnics/');

        }

        if ($hasBack) {
            $file = $request->file("owners.{$index}.cnic_back");
            $pathback = $this->uploadRepresentativeFile($file, 'uploads/user/cnics/');

        }

        Inheritance::where('id', $index)->update([
            'cnic_front' => $pathfront,
            'cnic_back'  => $pathback,
        ]);
    }}
}




        $req = Requests::create([
            'user_id'      => auth()->user()->id,
            'property_id'  => $id,
            'request_type' => $validated['request_type'],
            'town'         => $validated['town'],
            'sector'       => $validated['sector'],
            'source'       => 'fd-'.auth()->user()->id,
        ]);

        $transferFile = TransferFile::create([
            'user_id' => auth()->user()->id,
            'property_id'  => $id,
            'request_id'    => $req->id,
            'amount'  => $validated['sold_price'],
            'shared_representative' => $request->has('shared_rep_check') ? true : false,
            'buyer_name' => $validated['buyers'][0]['name'],
            'buyer_fname' => $validated['buyers'][0]['fname'],
            'buyer_cnic' => $validated['buyers'][0]['cnic'],
           'buyer_cnicfront' => $request->hasFile('buyers.0.cnicfront')
        ? $this->uploadRepresentativeFile($request->file('buyers.0.cnicfront'), 'uploads/user/cnics/')
        : null,

    'buyer_cnicback'  => $request->hasFile('buyers.0.cnicback')
        ? $this->uploadRepresentativeFile($request->file('buyers.0.cnicback'), 'uploads/user/cnics/')
        : null,
            'representative' => $validated['buyers'][0]['mode'] ?? 'shared_representative',

        ]);

        // STEP 2: Create shared attorney if provided
        if ($request->has('shared_attorney_check')) {
            $shared = Representative::create([
                'type'        => 'attorney',
                'name'        => $request->input('shared_attorney.name'),
                'father_name' => $request->input('shared_attorney.father_name'),
                'cnic'        => $request->input('shared_attorney.cnic'),
                'phone'       => $request->input('shared_attorney.phone'),
                'address'     => $request->input('shared_attorney.address'),
                'attorney_letter'     => $this->uploadRepresentativeFile($request->file('shared_attorney.attorney_letter')),
                'cnic_front'  => $this->uploadRepresentativeFile($request->file('shared_attorney.cnic_front')),
                'cnic_back'   => $this->uploadRepresentativeFile($request->file('shared_attorney.cnic_back')),
            ]);

            $transferFile->update([
                'shared_attorney_id' => $shared->id,
                'shared_attorney' => true,
                'any_attorney' => true,
            ]);
        }



        // STEP 3: Create personal attorneys for sellers if needed
        if ($request->has('seller_request')) {
            foreach ($request->seller_request as $sellerId) {
                $selectedMode = $request->seller_mode[$sellerId] ?? 'self';

                // Initialize variables
                $mode = $selectedMode;
                $representativeId = null;

                // Logic for shared attorney
                if ($request->has('shared_attorney_check') && isset($shared)) {
                    // Only switch to shared_attorney if the selected mode is 'attorney'
                    if ($selectedMode === 'attorney') {
                        $mode = 'shared_attorney';
                        $representativeId = $shared->id;
                    }
                    // If selected mode is 'self', mode remains 'self' (no change)
                }
                $representativeId = null;

                if ($mode === 'attorney' && isset($request->attorney[$sellerId])) {
                    $attorneyData = $request->attorney[$sellerId];

                    $attorney = Representative::create([
                        'type'        => 'attorney',
                        'name'        => $attorneyData['name'],
                        'father_name' => $attorneyData['father_name'],
                        'cnic'        => $attorneyData['cnic'],
                        'phone'       => $attorneyData['phone'],
                        'address'     => $attorneyData['address'],
                        'attorney_letter'     => $this->uploadRepresentativeFile($request->file("attorney.$sellerId.attorney_letter"),'uploads/user/representative/letter'),
                        'cnic_front'  => $this->uploadRepresentativeFile($request->file("attorney.$sellerId.cnic_front"),'uploads/user/representative/cnic'),
                        'cnic_back'   => $this->uploadRepresentativeFile($request->file("attorney.$sellerId.cnic_back"),'uploads/user/representative/cnic'),
                    ]);
                    $transferFile->update([
                    'any_attorney' => true,
                    ]);

                    $representativeId = $attorney->id;
                }

                    RequestParticipents::create([
                    'transfer_file_id'  => $transferFile->id,
                    'request_id'        => $req->id,
                    'owner_id'          => $sellerId,
                    'mode'              => $mode,
                    'representative_id' => $representativeId,
                ]);
            }
        }

        // STEP 5: Buyer representative if selected
        foreach ($request->buyers as $index => $buyerData) {
        $buyer = DummyReceiver::create([
            'request_id' => $req->id,
            'name' => $buyerData['name'],
            'father_name' => $buyerData['fname'],
            'cnic' => $buyerData['cnic'],
            'receiver_type' => $request->shared_rep_check == 1 ? 'shared_representative' : ($buyerData['mode'] ?? 'self'),
            'cnic_front' => $request->hasFile("buyers.$index.cnic_front") ? $this->uploadRepresentativeFile($request->file("buyers.$index.cnic_front"), 'uploads/user/cnics') : null,
            'cnic_back' => $request->hasFile("buyers.$index.cnic_back") ? $this->uploadRepresentativeFile($request->file("buyers.$index.cnic_back"), 'uploads/user/cnics') : null,
        ]);


        // 3. Store Representative Logic
        if ($request->shared_rep_check == 1) {
            $id = Representative::create([

                'type' => 'representative',
                'name' => $request->shared_representative['name'],
                'father_name' => $request->shared_representative['father_name'] ?? null,
                'cnic' => $request->shared_representative['cnic'],
                'phone' => $request->shared_representative['phone'] ?? null,
                'address' => $request->shared_representative['address'],
                'attorney_letter' => $request->hasFile("shared_representative.rep_attorney_letter") ? $this->uploadRepresentativeFile($request->file("shared_representative.rep_attorney_letter"), 'uploads/user/representative/letter') : null,
                'cnic_front' => $request->hasFile("shared_representative.rep_cnic_front") ? $this->uploadRepresentativeFile($request->file("shared_representative.rep_cnic_front"), 'uploads/user/representative/cnic') : null,
                'cnic_back' => $request->hasFile("shared_representative.rep_cnic_back") ? $this->uploadRepresentativeFile($request->file("shared_representative.rep_cnic_back"), 'uploads/user/representative/cnic') : null,
            ]);

            $transferFile->update([
                'shared_representative_id' => $id->id,
                'shared_representative' => true,
            ]);
            $buyer->update([
                'receiver_type' => 'shared_representative',
                'representative_id' => $id->id,
            ]);
        } elseif (($buyerData['mode'] ?? 'self')  === 'representative') {
            $id = Representative::create([

                'type' => 'representative',
                'name' => $buyerData['rep_name'],
                'father_name' => $buyerData['rep_fname'] ?? null,
                'cnic' => $buyerData['rep_cnic'],
                'phone' => $buyerData['rep_phone'] ?? null,
                'address' => $buyerData['rep_address'] ?? null,
                'attorney_letter' => $request->hasFile("buyers.$index.rep_attorney_letter") ? $this->uploadRepresentativeFile($request->file("buyers.$index.rep_attorney_letter"), 'uploads/user/representative/letter') : null,
                'cnic_front' => $request->hasFile("buyers.$index.rep_cnic_front") ? $this->uploadRepresentativeFile($request->file("buyers.$index.rep_cnic_front"), 'uploads/user/representative/cnic') : null,
                'cnic_back' => $request->hasFile("buyers.$index.rep_cnic_back") ? $this->uploadRepresentativeFile($request->file("buyers.$index.rep_cnic_back"), 'uploads/user/representative/cnic') : null,
            ]);

            $buyer->update([
                'representative_id' => $id->id,
            ]);
        }
    }

        DB::commit();

        return redirect('/frontdesk-check-requests')->with('success', 'Transfer request stored successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage());

        \Log::error('Transfer File Store Error: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->withErrors([
            'error' => 'Something went wrong: '.$e->getMessage()
        ])->withInput();
    }
}


    public function transferFile($id)
    {
        $type = request()->query('type');
        $cnic = request()->query('cnic');

        $exist = DB::table('requests')->where('property_id', $id)->latest()->first();

        if ($exist) {

            // ❌ If DEO action is null → cannot request
            if ($exist->deo_action === null) {
                return redirect()->back()
                    ->with('warning', 'Your previous request is still pending. You cannot request again.');
            }


            if ($exist->deo_action == 1 && $exist->dd_action == null) {
                return redirect()->back()
                    ->with('warning', 'Your previous request has already been processed.');
            }

        }
        $property = Property::with('owners')->where('id', $id)->first();

        if ($type == 1 || $type == 3) {
            return view('desk.transferFile', compact('property', 'type','cnic'));
        }
        if ($type == 2) {
            return view('user.warasat', compact('property', 'type'));
        }
    }

    public function checkRequests(){

        $id = auth()->user()->id;
        $properties = Requests::with([
            'property.township'
        ])
        ->where('source','like','fd-%'.$id)
        ->get();

        return view('desk.propertylist', compact('properties'));

    }
    private function uploadRepresentativeFile($file, $folder = 'uploads/user/representative/cnic')
    {
    if (!$file) {
        return null;
    }

    // create unique filename: timestamp + random string + original name
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // move to public/uploads/users/representative/cnic
    $file->move(public_path($folder), $filename);

    // return relative path to store in DB
    return  $filename;
}


    private function warassatStore(Request $request,$id){
        $rules = [

        'buyer_name'  => 'required|string',
        'buyer_fname' => 'required|string',
        'buyer_cnic'  => 'required|string',
        'death_date'  => 'required',
        'death_certificate' => 'required|image|mimes:jpg,jpeg,png,pdf|max:2048',
        'request_type' => 'required',
        'town' => 'required',
        'sector' => 'required',
        'death_place' => 'required',
        'seller_request' => 'required',

    ];

    $validated = $request->validate($rules);
    // dd($validated);
    try {
        // DB::beginTransaction();
        if ($request->hasFile('death_certificate')) {

        // Get the file
        $file = $request->file('death_certificate');

        // Create a unique file name (using uniqid + original name)
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Store file inside public/uploads/death_certificates
        $file->move(public_path('uploads/user/death_certificates'), $filename);
        $validated['death_certificate'] = $filename;
    }

    $req = Requests::create([
        'user_id'      => auth()->user()->id,
        'property_id'  => $id,
        'request_type' => $validated['request_type'],
        'town'         => $validated['town'],
        'sector'       => $validated['sector'],
        'source'       => 'fd-'.auth()->user()->id,
    ]);

    $transferFile = TransferFile::create([
        'user_id' => auth()->user()->id,
        'property_id'  => $id,
        'request_id'    => $req->id,
        'buyer_name' => $validated['buyer_name'],
        'buyer_fname' => $validated['buyer_fname'],
        'buyer_cnic' => $validated['buyer_cnic'],
        'death_date' => $validated['death_date'],
        'death_certificate' => $validated['death_certificate'],
        'death_place' => $validated['death_place'],
    ]);



        // STEP 3: Create personal attorneys for sellers if needed
        if ($request->has('seller_request')) {
            foreach ($request->seller_request as $sellerId) {
                    RequestParticipents::create([
                    'transfer_file_id'  => $transferFile->id,
                    'request_id'        => $req->id,
                    'owner_id'          => $sellerId,
                    'mode'              => 'self',
                ]);

            }
        }

        return redirect()->route('fd.checkrequest')
        ->with('success', 'Warassat Transfer request stored successfully!');
        // DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage());

        \Log::error('Transfer File Store Error: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->withErrors([
            'error' => 'Something went wrong: '.$e->getMessage()
        ])->withInput();
    }
    }

    public function houseConstructionForm($id)
    {
        $property = Property::with('owners')->find($id);

        if (!$property) {
            return redirect()->back()->withErrors(['error' => 'Property not found']);
        }

        return view('desk.house-construction', compact('property'));
    }

    public function houseConstructionStore(Request $request, $id)
{

    try {


        $property = Property::find($id);
        if (!$property) {
            \Log::warning('Property not found', ['property_id' => $id]);
            return redirect()->back()->withErrors(['error' => 'Property not found'])->withInput();
        }

        if (!$request->has('select_owners') || empty($request->select_owners)) {
            return redirect()->back()->withErrors(['error' => 'Please select at least one owner'])->withInput();
        }

        // ---------------------------------------------------------------
        // Validation
        // Attorney fields are ONLY required when representation_type = attorney
        // Everything else is optional when representation_type = self
        // ---------------------------------------------------------------
        $validated = $request->validate([
            'select_owners'                => 'required|array|min:1',
            'select_owners.*'              => 'exists:inheritances,id',
            'representation_type'          => 'required|in:self,attorney',

            // Architect
            'architect_name'               => 'required|string|max:255',
            'architect_address'            => 'required|string|max:255',
            'architect_stamp_signature'    => 'required|mimes:pdf,png|max:10240',

            // Engineer
            'engineer_name'                => 'required|string|max:255',
            'engineer_address'             => 'required|string|max:255',
            'engineer_stamp_signature'     => 'required|mimes:pdf,png|max:10240',

            // Area / Amount
            'area_per_sqft'                => 'required|numeric|min:0',
            'total_amount'                 => 'required|numeric|min:0',

            // Attorney — all fields ONLY required when attorney is selected
            'attorney_name'                => 'required_if:representation_type,attorney|nullable|string|max:255',
            'attorney_father_name'         => 'required_if:representation_type,attorney|nullable|string|max:255',
            'attorney_cnic'                => 'required_if:representation_type,attorney|nullable|string|max:15',
            'attorney_address'             => 'required_if:representation_type,attorney|nullable|string|max:500',
            'attorney_cnic_front'          => 'required_if:representation_type,attorney|nullable|image|mimes:jpeg,png,jpg|max:2048',
            'attorney_cnic_back'           => 'required_if:representation_type,attorney|nullable|image|mimes:jpeg,png,jpg|max:2048',
            'attorney_letter'              => 'required_if:representation_type,attorney|nullable|file|mimes:pdf,doc,docx|max:5120',

            // Map — three separate inputs (one per format)
            'approved_map_pdf'             => 'required|file|mimes:pdf|max:20480',
            'approved_map_png'             => 'required|image|mimes:png,jpg,jpeg|max:20480',
            'approved_map_dwg'             => 'nullable|file|max:20480', // dwg/dxf not in Laravel mime list
        ], [
            'architect_stamp_signature.mimes'  => 'Architect stamp must be a PDF or PNG file.',
            'architect_stamp_signature.max'    => 'Architect stamp must not exceed 10MB.',
            'engineer_stamp_signature.mimes'   => 'Engineer stamp must be a PDF or PNG file.',
            'engineer_stamp_signature.max'     => 'Engineer stamp must not exceed 10MB.',
            'attorney_name.required_if'        => 'Attorney name is required when representation type is Attorney.',
            'attorney_father_name.required_if' => 'Attorney father name is required when representation type is Attorney.',
            'attorney_cnic.required_if'        => 'Attorney CNIC is required when representation type is Attorney.',
            'attorney_address.required_if'     => 'Attorney address is required when representation type is Attorney.',
            'attorney_cnic_front.required_if'  => 'Attorney CNIC front image is required when representation type is Attorney.',
            'attorney_cnic_back.required_if'   => 'Attorney CNIC back image is required when representation type is Attorney.',
            'attorney_letter.required_if'      => 'Attorney letter is required when representation type is Attorney.',
            'approved_map_pdf.max'             => 'Approved map PDF must not exceed 20MB.',
            'approved_map_png.max'             => 'Approved map image must not exceed 20MB.',
            'approved_map_dwg.max'             => 'Approved map AutoCAD file must not exceed 20MB.',
        ]);



        DB::beginTransaction();

        // Step 1: Create Request record
        $requestRecord = Requests::create([
            'user_id'      => auth()->user()->id,
            'property_id'  => $id,
            'town'         => $property->town_id ?? 0,
            'sector'       => $property->sector ?? '',
            'request_type' => 4,
            'source'       => 'fd-' . auth()->user()->id,
        ]);





        // Step 3: Attorney handling
        // ✅ Always initialize to null — avoids undefined variable when mode = self
        $attorneyCnicFront  = null;
        $attorneyCnicBack   = null;
        $attorneyLetter     = null;
        $representativeId   = null;
        $mode               = $request->representation_type;

        if ($mode === 'attorney') {
            if ($request->hasFile('attorney_cnic_front')) {
                $file = $request->file('attorney_cnic_front');
                $attorneyCnicFront = time() . '_attorney_cnic_front_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/attorney'), $attorneyCnicFront);
            }

            if ($request->hasFile('attorney_cnic_back')) {
                $file = $request->file('attorney_cnic_back');
                $attorneyCnicBack = time() . '_attorney_cnic_back_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/attorney'), $attorneyCnicBack);
            }

            if ($request->hasFile('attorney_letter')) {
                $file = $request->file('attorney_letter');
                $attorneyLetter = time() . '_attorney_letter_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/attorney'), $attorneyLetter);
            }

            $representative   = Representative::create([
                'name'            => $validated['attorney_name'],
                'father_name'     => $validated['attorney_father_name'],
                'cnic'            => $validated['attorney_cnic'],
                'address'         => $validated['attorney_address'],
                'cnic_front'      => $attorneyCnicFront,
                'cnic_back'       => $attorneyCnicBack,
                'attorney_letter' => $attorneyLetter,
            ]);

            $representativeId = $representative->id;
            \Log::info('Attorney representative created', ['representative_id' => $representativeId]);
        }

        // Step 4: Request participants for each selected owner
        foreach ($validated['select_owners'] as $ownerId) {
            RequestParticipents::create([

                'request_id'        => $requestRecord->id,
                'owner_id'          => $ownerId,
                'mode'              => $mode,
                'representative_id' => $representativeId, // null when mode = self
            ]);
        }

        \Log::info('Request participants created', ['count' => count($validated['select_owners'])]);

        // Step 5: Upload architect / engineer stamps
        $architectStampName = null;
        if ($request->hasFile('architect_stamp_signature')) {
            $file = $request->file('architect_stamp_signature');
            $architectStampName = time() . '_architect_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/architecture'), $architectStampName);
        }

        $engineerStampName = null;
        if ($request->hasFile('engineer_stamp_signature')) {
            $file = $request->file('engineer_stamp_signature');
            $engineerStampName = time() . '_engineer_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/architecture'), $engineerStampName);
        }

        // Step 6: Upload the three separate map files (PDF / IMAGE / AutoCAD)
        $approvedMapPdf = null;
        if ($request->hasFile('approved_map_pdf')) {
            $file = $request->file('approved_map_pdf');
            $approvedMapPdf = time() . '_map_pdf_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/maps'), $approvedMapPdf);
        }

        $approvedMapPng = null;
        if ($request->hasFile('approved_map_png')) {
            $file = $request->file('approved_map_png');
            $approvedMapPng = time() . '_map_img_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/maps'), $approvedMapPng);
        }

        $approvedMapDwg = null;
        if ($request->hasFile('approved_map_dwg')) {
            $file = $request->file('approved_map_dwg');
            $approvedMapDwg = time() . '_map_dwg_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/maps'), $approvedMapDwg);
        }

        // Step 7: Store SmallRequest
        $smallRequest = SmallRequest::create([
            'request_id'               => $requestRecord->id,
            'property_id'              => $id,
            'user_id'                  => auth()->user()->id,
            'architect_name'           => $validated['architect_name'],
            'architect_address'        => $validated['architect_address'],
            'architect_stamp_signature'=> $architectStampName,
            'engineer_name'            => $validated['engineer_name'],
            'engineer_address'         => $validated['engineer_address'],
            'engineer_stamp_signature' => $engineerStampName,
            'area_per_sqft'            => $validated['area_per_sqft'] ?? null,
            'total_amount'             => $validated['total_amount'] ?? null,

            // Three map columns — add these to your migration/model if not already there
            'approved_map_pdf'         => $approvedMapPdf,
            'approved_map_png'         => $approvedMapPng,
            'approved_map_dwg'         => $approvedMapDwg,
        ]);

        \Log::info('Small request record created', ['small_request_id' => $smallRequest->id]);

        DB::commit();

        return redirect()->route('fd.checkrequest')
            ->with('success', 'House Construction Permission request submitted successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        \Log::error('Validation Error', ['errors' => $e->errors()]);
        return redirect()->back()->withErrors($e->errors())->withInput();

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('House Construction Store Error: ' . $e->getMessage(), [
            'trace'       => $e->getTraceAsString(),
            'property_id' => $id
        ]);
        return redirect()->back()
            ->withErrors(['error' => 'Error submitting form: ' . $e->getMessage()])
            ->withInput();
    }
}




public function objectionRequests(){
    // $id = auth()->user()->id;
    // $properties = Requests::with('property')->where('source','like','fd-%'.$id)->get();

    return view('desk.objectionlist');
}
public function CheckObjectionRequests(){
    // $id = auth()->user()->id;
    // $properties = Requests::with('property')->where('source','like','fd-%'.$id)->get();

    return view('user.objectionTracking');
}

}
