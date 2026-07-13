<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Attchement;
use App\Models\Biometric;
use App\Models\ManualTransfer;
use App\Models\PropertyThumb;
use Illuminate\Http\Request;
use App\Models\TransferedProperty;
use App\Models\TransferFile;
use App\Models\Requests;
use App\Models\Property;
use App\Models\Inheritance;
use App\Models\Representative;
use App\Models\Witness;
use App\Models\PropertyDocument;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use DB, File;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Support\Facades\Cache;

class DDController extends Controller
{
    public function storeVerification(Request $request,$type)
    {



        foreach (['seller', 'receiver', 'witness', 'biometrics'] as $key) {
            if ($request->has($key) && is_string($request->$key)) {
                $request->merge([
                    $key => json_decode($request->$key, true)
                ]);
            }
        }
        if($type == 2){
            return $this->storeWarassatVerification($request);

        }


        $rules = [
            'requester'   => 'required|array|min:1',
            'receiver' => 'required|array|min:1',
            'witness'  => 'required|array|min:1',
            'biometrics'     => 'required|array',
            'id'             => 'required|integer',
            'property_id'    => 'required|integer',
            'snapshot_step3' => 'required|string',
            'snapshot_step4' => 'required|string',
            'shared_attorney_check' => 'required',
            'shared_attorney_id' => 'nullable',
            'shared_representative_check' => 'required',
            'shared_representative_id' => 'nullable',
        ];

        // Sellers
        if ($request->has('requester')) {

            // First check if shared attorney is provided

            if ($request->has('shared_attorney_check') && $request->shared_attorney_check) {


                // Validate shared attorney fields
                $rules["attorney.0.name"]        = 'required|string|max:255';
                $rules["attorney.0.id"]        = 'required';
                $rules["attorney.0.father_name"] = 'required|string|max:255';
                $rules["attorney.0.cnic"]        = 'required|string|size:13';
                $rules["attorney.0.picture"]     = 'required|string';
            } else {

                // No shared attorney → check seller one by one
                foreach ($request->requester as $key => $seller) {
                    $rules["requester.$key.id"]          = 'required';
                    $rules["requester.$key.name"]        = 'required|string|max:255';
                    $rules["requester.$key.father_name"] = 'required|string|max:255';
                    $rules["requester.$key.cnic"]        = 'required|string|size:13';
                    $rules["requester.$key.mode"] = 'required';


                    if (!empty($seller['mode']) && $seller['mode'] === 'attorney') {
                        // Seller has attorney → attorney required
                        $rules["requester.$key.picture"]              = 'nullable|string';
                        $rules["attorney.$key.name"]        = 'required|string|max:255';
                        $rules["attorney.$key.owner_id"]        = 'required|string|max:255';
                        $rules["attorney.$key.id"]        = 'required';
                        $rules["attorney.$key.father_name"] = 'required|string|max:255';
                        $rules["attorney.$key.cnic"]        = 'required|string|size:13';

                        $rules["attorney.$key.picture"]     = 'required|string';
                    } else {
                        // Seller is self → picture required
                        $rules["requester.$key.picture"] = 'required|string';
                    }
                }
            }
        }


        // Receivers
        if ($request->has('receiver')) {
             if ($request->has('shared_representative_check') && $request->shared_representative_check) {
                 // Validate shared representative fields
                $rules["representative.0.name"]        = 'required|string|max:255';
                $rules["representative.0.id"]        = 'required';
                $rules["representative.0.father_name"] = 'required|string|max:255';
                $rules["representative.0.cnic"]        = 'required|string|size:13';
                $rules["representative.0.picture"]     = 'required|string';
             } else{

                 foreach ($request->receiver as $key => $receiver) {
                     // Receiver common fields
                $rules["receiver.$key.name"]        = 'required|string|max:255';
                $rules["receiver.$key.address"]     = 'required|string';
                $rules["receiver.$key.id"]     = 'required';
                $rules["receiver.$key.father_name"] = 'required|string|max:255';
                $rules["receiver.$key.cnic"]        = 'required|string|size:13';
                $rules["receiver.$key.cnic_front"]  = 'required|string';
                $rules["receiver.$key.cnic_back"]   = 'required|string';
                $rules["receiver.$key.area"]        = 'required';
                $rules["receiver.$key.mode"]        = 'nullable';


                // Representative logic
                if (!empty($receiver['mode']) && $receiver['mode'] === 'representative') {
                    // Receiver's picture becomes optional
                    $rules["receiver.$key.picture"] = 'nullable|string';

                    // Representative fields required
                    $rules["representative.$key.name"]        = 'required|string|max:255';
                    $rules["representative.$key.id"]        = 'required';
                    $rules["representative.$key.father_name"] = 'required|string|max:255';
                    $rules["representative.$key.cnic"]        = 'required|string|size:13';
                    $rules["representative.$key.picture"]     = 'required|string';
                    $rules["representative.$key.receiver_id"]     = 'nullable';
                } else {
                    // Self receiver → picture required
                    $rules["receiver.$key.picture"] = 'required|string';
                    }
                    }
                    }
        }

        // Witnesses (unchanged)
        if ($request->has('witness')) {
            foreach ($request->witness as $key => $witness) {
                $rules["witness.$key.name"]        = 'required|string|max:255';
                $rules["witness.$key.father_name"] = 'required|string|max:255';
                $rules["witness.$key.cnic"]        = 'required|string|size:13';
                $rules["witness.$key.address"]     = 'required|string';
                $rules["witness.$key.cnic_front"]  = 'required|string';
                $rules["witness.$key.cnic_back"]   = 'required|string';
                $rules["witness.$key.picture"]     = 'required|string';
            }
        }
        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $data = $validator->validated();

        } catch (ValidationException $e) {
            dd($e->errors(),$request->all());
        }



        // dd($data);
        try {
            DB::beginTransaction();
            // Handle base64 images
            // Handle Seller pictures
            if (!empty($data['requester'])) {
                if ($data['shared_attorney_check']) {
                    if (!empty($data['attorney'][0])) {

                        // ✅ Check if seller picture is base64
                        $isBase64 = preg_match('/^data:image\/[a-zA-Z]+;base64,/', $data['attorney'][0]['picture']);

                        $data['attorney'][0]['picture'] = $isBase64
                            ? $this->storeBase64Image($data['attorney'][0]['picture'], 'attorney')  // save only if base64
                            : ''; // reuse filename if already stored
                        $data['attorney'][0]['owner_id'] = $data['shared_attorney_id'];
                    }
                } else {
                    foreach ($data['requester'] as $key => $seller) {

                        if (!empty($seller['picture'])) {
                            // ✅ Check if seller picture is base64
                            $isBase64 = preg_match('/^data:image\/[a-zA-Z]+;base64,/', $seller['picture']);
                            $data['requester'][$key]['picture'] = $isBase64
                                ? $this->storeBase64Image($seller['picture'], 'seller')  // save only if base64
                                : ''; // reuse filename if already stored

                        } else {
                            foreach ($data['attorney'] as $key1 => $attorney) {
                                if ($attorney['owner_id'] == $seller['id']) {
                                    if (!empty($attorney['picture'])) {
                                        // ✅ Check if seller picture is base64
                                        $isBase64 = preg_match('/^data:image\/[a-zA-Z]+;base64,/', $attorney['picture']);

                                        $data['attorney'][$key1]['picture'] = $isBase64
                                            ? $this->storeBase64Image($attorney['picture'], 'attorney')  // save only if base64
                                            : ''; // reuse filename if already stored
                                    }
                                }
                            }
                        }
                    }
                }
            }


            // dd($data,$request->all());
            if (!empty($data['receiver'])) {
                if($data['shared_representative_check'] == 1){

                    if (!empty($data['representative'][0])) {

                        // ✅ Check if seller picture is base64
                        $isBase64 = preg_match('/^data:image\/[a-zA-Z]+;base64,/', $data['representative'][0]['picture']);

                        $data['representative'][0]['picture'] = $isBase64
                            ? $this->storeBase64Image($data['representative'][0]['picture'], 'representative')  // save only if base64
                            : ''; // reuse filename if already stored
                        $data['representative'][0]['receiver_id'] = $data['shared_representative_id'];
                    }
                } else {
                foreach ($data['receiver'] as $key => $receiver) {

                    if (!empty($receiver['picture'])) {


                        // ✅ Check if seller picture is base64
                            $isBase64 = preg_match('/^data:image\/[a-zA-Z]+;base64,/', $receiver['picture']);
                            $data['receiver'][$key]['picture'] = $isBase64
                                ? $this->storeBase64Image($receiver['picture'], 'receiver')  // save only if base64
                                : ''; // reuse filename if already stored
                    } else {
                        foreach ($data['representative'] as $key1 => $attorney) {

                            if ($attorney['receiver_id'] == $receiver['id']) {
                            if (!empty($attorney['picture'])) {
                                // ✅ Check if seller picture is base64
                                $isBase64 = preg_match('/^data:image\/[a-zA-Z]+;base64,/', $attorney['picture']);

                                $data['representative'][$key1]['picture'] = $isBase64
                                    ? $this->storeBase64Image($attorney['picture'], 'representative')  // save only if base64
                                    : ''; // reuse filename if already stored
                            }
                            }

                        }
                    }
                }
            }}

            // Handle Witness pictures
            if (!empty($data['witness'])) {
                foreach ($data['witness'] as $key => $witness) {
                    if (!empty($witness['picture'])) {
                        $data['witness'][$key]['picture'] = $this->storeBase64Image(
                            $witness['picture'],
                            'witness'
                        );
                    }
                }
            }





            $req = TransferFile::find($request->id);



            // Handle biometric data
            // $thumbs = json_decode($request->biometrics);
            $biometricMap = [];
            // Store biometrics and index them by CNIC
            foreach ($data['biometrics'] as $key => $value) {

                foreach ($value as $key1 => $value1) {
                    if ($key == 'requester') {
                        $isBase64 = preg_match('/^data:image\/[a-zA-Z]+;base64,/', $value1['image']);


                        $bio = Biometric::updateOrCreate(
                            ['cnic' => $value1['cnic']], // condition

                            [
                                'cnic'        => $value1['cnic'],
                                'image'       => $isBase64
                                    ? $this->storeBase64BiometricImage($value1['image'], $key, $value1['cnic'])
                                    : $value1['image'], // reuse file path if already stored
                                'code'        => $value1['code'],
                                'status'      => $value1['status'],
                                'template'    => $value1['template'],
                                'device_type' => $value1['deviceType'],
                                'timestamp'   => $value1['timestamp'] ?? now(),
                            ]
                        );
                    } else {

                        $bio = Biometric::create([
                            'cnic'        => $value1['cnic'],
                            'image'       => $this->storeBase64BiometricImage($value1['image'], $key, $value1['cnic']),
                            'code'        => $value1['code'],
                            'status'      => $value1['status'],
                            'template'    => $value1['template'],
                            'device_type' => $value1['deviceType'],
                            'timestamp'   => $value1['timestamp'] ?? now(),
                        ]);
                    }

                    $biometricMap[$value1['cnic']] = $bio->id;
                }
            }


            // Extract requester IDs from request
            $requesterIds = collect($request->requester)->pluck('id')->filter()->all();

            // Fetch matching inheritance entries
            $inheritanceRecords = Inheritance::whereIn('id', $requesterIds)->update(['is_current' => NULL]);

            // ✅ Build a map of attorneys keyed by owner_id for fast lookup
            $attorneyByOwner = collect($data['attorney'] ?? [])
                ->keyBy('owner_id');
            $attorneyByReceiver = collect($data['representative'] ?? [])
                ->keyBy('receiver_id');


                // ✅ Loop through sellers once
                foreach ($data['requester'] as $seller) {


            $biometricId = $biometricMap[$seller['cnic']] ?? null;

                // 1️⃣ Update seller inheritance record
                Inheritance::where('id', $seller['id'])->update([
                    'biometric_id' => $biometricId,
                    'picture' => $seller['picture'] ?? null,
                ]);
                if($data['shared_attorney_check'] == 11){
                    $attorney = $attorneyByOwner[$data['shared_attorney_id']];

                    Representative::where('id', $attorney['id'])->update([
                        'picture' => $attorney['picture'] ?? null,
                        'biometric_id' => $biometricMap[$attorney['cnic']] ?? null,
                        ]);
                        }

                        if (isset($attorneyByOwner[$seller['id']])) {

                    $attorney = $attorneyByOwner[$seller['id']];


                    Representative::where('id', $attorney['id'])->update([
                        'picture' => $attorney['picture'] ?? null,
                        'biometric_id' => $biometricMap[$attorney['cnic']] ?? null,
                    ]);
                }
            }


            // ✅ Loop once through receivers
            foreach ($data['receiver'] as $receiver) {
                $biometricId = $biometricMap[$receiver['cnic']] ?? null;

                $rep = null;
                 if($data['shared_representative_check']){

                    $rep = $attorneyByReceiver[$data['shared_representative_id']];
                    Representative::where('id', $rep['id'])->update([
                        'picture' => $rep['picture'] ?? null,
                        'biometric_id' => $biometricMap[$rep['cnic']] ?? null,
                        ]);
                        }



                 if (isset($attorneyByReceiver[$receiver['id']])) {
                    $rep = $attorneyByReceiver[$receiver['id']];
                    Representative::where('id', $rep['id'])->update([
                        'picture' => $rep['picture'] ?? null,
                        'biometric_id' => $biometricMap[$rep['cnic']] ?? null,
                    ]);
                }


                // 1️⃣ Create inheritance entry for receiver
                $inheritance = Inheritance::create([
                    'request_id'   => $req->request_id,
                    'property_id'  => $data['property_id'],
                    'name'         => $receiver['name'],
                    'father_name'  => $receiver['father_name'],
                    'area'         => $receiver['area'],
                    'cnic'         => $receiver['cnic'],
                    'cnic_front'   => $receiver['cnic_front'],
                    'cnic_back'    => $receiver['cnic_back'],
                    'address'      => $receiver['address'] ?? null,
                    'picture' => $rep ? null : $receiver['picture'], // 👈 key condition
                    'is_current'   => 1,
                    'biometric_id' => $rep ? null : $biometricId, // 👈 key condition
                ]);


                // 2️⃣ If receiver has a representative, update representative data

            }


            foreach ($data['witness'] as $seller) {
                $biometricId = $biometricMap[$seller['cnic']] ?? null;

                Witness::create([
                    'request_id'  => $req->request_id,
                    'property_id'       => $data['property_id'],
                    'name'       => $seller['name'],
                    'father_name' => $seller['father_name'],
                    'cnic'       => $seller['cnic'],
                    'cnic_front' => $seller['cnic_front'],
                    'cnic_back'  => $seller['cnic_back'],
                    'address'    => $seller['address'] ?? null,
                    'picture'    => $seller['picture'],
                    'biometric_id'      => $biometricId,
                ]);
            }

            $path1 = $this->storeBase64Image($data['snapshot_step3'], 'statement');
            $path2 = $this->storeBase64Image($data['snapshot_step4'], 'statement');


            // Update e file
            TransferFile::where('id', $request->id)->update([
                'seller_declaration' => $path1,
                'buyer_declaration' => $path2,
            ]);

            // Update request


            $property = Property::findOrFail($request->property_id);
            $reque     = Requests::findOrFail($req->request_id);
            // Store latest transfer type
            $property->latest_transfer = $reque->request_type;

            switch ($reque->request_type) {
                case 1:
                    $property->sale_count = ($property->sale_count ?? 0) + 1;
                    break;
                case 2:
                    $property->warasat_count = ($property->warasat_count ?? 0) + 1;
                    break;
                case 3:
                    $property->hiba_count = ($property->hiba_count ?? 0) + 1;
                    break;
            }

            // Save latest_transfer (increment saves automatically, but this is safe)
            $property->save();

            Requests::where('id', $req->request_id)->update([
                'dd_action' => '1',
                'dd_action_date' => now()->format('Y-m-d'),
                'dd_id' => auth()->user()->id,

            ]);

            DB::commit();


            return redirect('/dd-transfer-list')->with('success', 'Property Transfered Successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Optional: Log the error
            \Log::error('Transaction failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Transaction failed. Nothing was saved.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    private function storeBase64Image($base64Image, $prefix)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, etc.

            $imageData = base64_decode($base64Image);

            $fileName = $prefix . '_' . time() . '_' . uniqid() . '.' . $type;
            if ($prefix == 'statement') {
                $directory = public_path('/uploads/user/statement');
            } else if ($prefix == 'attorney') {
                $directory = public_path('/uploads/user/representative/image');
            } else if ($prefix == 'representative') {
                $directory = public_path('/uploads/user/representative/image');
            } else {
                $directory = public_path('/uploads/user/images');
            }

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $filePath = $directory . '/' . $fileName;

            file_put_contents($filePath, $imageData);

            return $fileName;
        }

        return null;
    }

    private function storeBase64BiometricImage($base64Image, $key, $cnic)
    {
        $type = 'png'; // Default to png if no mime type is given

        // Check if the image has a prefix like "data:image/png;base64,"
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
            $type = strtolower($matches[1]); // jpg, png, etc.
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
        }

        // Attempt to decode the base64 string
        $imageData = base64_decode($base64Image, true);
        if ($imageData === false) {
            dump("Invalid base64 data");
            return null;
        }

        // Sanitize inputs
        $key = preg_replace('/[^a-zA-Z0-9]/', '', $key);
        $cnic = preg_replace('/[^0-9]/', '', $cnic);

        // Create filename and directory
        $fileName = "{$key}_{$cnic}.{$type}";
        $directory = public_path('/uploads/user/biometric/');

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $filePath = $directory . '/' . $fileName;

        // Save the image
        file_put_contents($filePath, $imageData);

        return $fileName;
    }



    public function transferList()
    {
       $data = Requests::with(['property.owners', 'statement'])
    ->whereRaw('id in (select request_id from transfer_attaches) OR request_type = 4')
    ->whereNull('dd_action')
    ->where(function($query) {
        $query->whereExists(function ($subQuery) {
            $subQuery->select(DB::raw(1))
                ->from('dummy_receivers')
                ->whereColumn('dummy_receivers.request_id', 'requests.id');
        })
        ->orWhere('request_type', 4); // Include Type 4 requests without dummy_receivers requirement
    })
    ->where(function($query) {
        $query->whereHas('statement', function ($subQuery) {
            $subQuery->whereNotNull('requester_statement')
                  ->whereNotNull('receiver_statement');
        })
        ->orWhere('request_type', 4); // Include Type 4 requests without statement requirement
    })
    ->get();




        return view('DD.transferList', compact('data'));
    }
    public function transferedProperties()
    {

        $data = Requests::with(['property.owners', 'statement'])
    ->where('dd_action', 1)
    ->whereDoesntHave('documents')
    ->whereHas('statement', function ($query) {
        // یہاں ہم چیک کر رہے ہیں کہ ٹرانسفر آرڈر نل (Null) نہ ہو اور خالی بھی نہ ہو
        $query->whereNotNull('transfer_order')
              ->where('transfer_order', '!=', '');
    })
    ->get();


        return view('DD.transferList', compact('data'));
    }

    public function oldpropertyTransfer($id)
    {
        $property = Property::where('id', $id)->first();
        return  view('DD.oldpropertytransfer', compact('property'));
    }
    public function PropertyVerify(Request $request)
    {
        $property = Property::with('attachment')->where('code', $request->search_input)->first();
        if (!$property) {
            return redirect()->back()->with('error', 'No Property Exists.');
        }
        $id = $request->search_input;


        return view('property.formDetail', compact('property', 'id'));
    }

    public function propertyVerification()
    {
        return view('DD.propertyVerification');
    }
    public function PropertyTransferOld(Request $request)
    {

        $data = $request->validate([
            'property_id' => '',
            'town_id' => '',

            "seller_name" => "required|string",
            "seller_father_name" => "required|string",
            "seller_cnic" => "required|string",
            "seller_address" => "required|string",
            "sold_price" => 'required',
            "buyer_name" => "required|string",
            "buyer_father_name" => "required|string",
            "buyer_cnic" => "required|string",
            "buyer_address" => "required|string",

            "first_witness_name" => "required|string",
            "first_witness_father_name" => "required|string",
            "first_witness_cnic" => "required|string",

            "second_witness_name" => "required|string",
            "second_witness_father_name" => "required|string",
            "second_witness_cnic" => "required|string",
            "allotment_order" => 'required',
            "transferred_date" => 'required',
        ]);
        if ($request->hasFile('allotment_order')) {
            $file = $request->file('allotment_order');
            $fileName = 'transfer_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/transfer_order/' . $fileName;
            file_put_contents($filePath, file_get_contents($file));
            $data['allotment_order'] = $fileName;
        }

        $data['user_id'] = auth()->user()->id;
        $dat = ManualTransfer::create($data);
        // Fetch the property row
        $property = Property::find($data['property_id']);


        if ($property) {


            // Update the original property with buyer's details
            $property->allotee_name = $data['buyer_name'];
            $property->relation = $data['buyer_father_name'];
            $property->cnic = $data['buyer_cnic'];
            $property->save();

            $attach = Attchement::create([
                'property_id' => $property->id,
                'transfer_order' => $data['allotment_order'],
            ]);
        }


        return redirect()->route('oldTransferList')->with('success', 'Property Transfered Successfully');
    }


    public function oldTransferList()
    {
        $data = DB::select(" SELECT
        properties.id AS property_id,
        properties.code,
        properties.plot_no,
        properties.sector,
        properties.center,
        properties.sector,
        towns.name AS town
    FROM
        manual_transfers
    LEFT JOIN
        properties ON properties.id = manual_transfers.property_id
    LEFT JOIN
        towns ON towns.id = properties.town

");
        return view('DD.oldtransfered', compact('data'));
    }

    public function generateTransferOrder($id)
    {


        $property = Requests::findOrFail($id);

        $data = Requests::with(['property.owners','participants.owner','transfer','transferAttaches','dummyreceiver'])->where('id',$id)->first();

        $receiver = $data->dummyreceiver->pluck('cnic')->toArray();
        $ownersNotReceivers = [];
        $i = 0;

        foreach ($data->property->owners as$key => $owner) {
            if (!in_array($owner->cnic, $receiver)) {
                $ownersNotReceivers[$i]['name'] = $owner->name;
                $ownersNotReceivers[$i]['father_name'] = $owner->father_name;
                $previousOwner[] = $owner->cnic;
                $i++;
            }
        }


        foreach($data->participants as $owner ){

            $ownersNotReceivers[$i]['name'] = $owner->owner->name;
            $ownersNotReceivers[$i]['father_name'] = $owner->owner->father_name;
            $previousOwner[] = $owner->owner->cnic;
            $i++;
        }
        // dd($ownersNotReceivers);

            $ownersWhoMadeRequest = [];
            foreach ($data->participants as $participant) {
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
        return view('DD.transferorder', compact('data','ownersNotReceivers','allOwnersMadeRequest','singleOwner','multipleRequest'));
    }
    private function generateWarassatOrder($id){
        $data = Requests::with(['property.owners','participants.owner','transfer','transferAttaches','dummyreceiver'])->where('id',$id)->first();

        $receiver = $data->dummyreceiver->pluck('cnic')->toArray();
        $ownersNotReceivers = [];
        $i = 0;

        foreach ($data->property->owners as$key => $owner) {
            if (!in_array($owner->cnic, $receiver)) {
                $ownersNotReceivers[$i]['name'] = $owner->name;
                $ownersNotReceivers[$i]['father_name'] = $owner->father_name;
                $previousOwner[] = $owner->cnic;
                $i++;
            }
        }


        foreach($data->participants as $owner ){

            $ownersNotReceivers[$i]['name'] = $owner->owner->name;
            $ownersNotReceivers[$i]['father_name'] = $owner->owner->father_name;
            $previousOwner[] = $owner->owner->cnic;
            $i++;
        }


        $ownersWhoMadeRequest = [];
        foreach ($data->participants as $participant) {
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

        return view('DD.warassatorder', compact('data','ownersNotReceivers','allOwnersMadeRequest','singleOwner','multipleRequest'));
    }


    public function storeWarassatVerification(Request $request){
      $data =  $request->validate([

        'requester_id'        => 'required',
        'witness'               => 'required|array|min:1',
        'witness.*.name'        => 'required|string|max:255',
        'witness.*.cnic'        => 'required|string|max:20',
        'witness.*.picture'        => 'required',
        'witness.*.father_name'        => 'required|string',
        'witness.*.address'        => 'required|string',
        'witness.*.cnic_front'        => 'required|string',
        'witness.*.cnic_back'        => 'required|string',

        'receiver'               => 'required|array|min:1',
        'receiver.*.name'        => 'required|string|max:255',
        'receiver.*.cnic'        => 'required|string|max:20',
        'receiver.*.father_name'        => 'required|string',
        'receiver.*.address'        => 'required|string',
        'receiver.*.area'        => 'required',
        'receiver.*.cnic_front'        => 'nullable',
        'receiver.*.cnic_back'        => 'nullable',
        'receiver.*.picture'        => 'nullable',
        'receiver.0.picture'        => 'required',


        'biometrics'            => 'required|array',

        'id'                    => 'required|integer',
        'request_id'                    => 'required|integer',
        'property_id'           => 'required|integer',

        'snapshot_step3'        => ['required', 'regex:/^data:image\/(png|jpeg);base64,/'],
        'snapshot_step4'        => ['required', 'regex:/^data:image\/(png|jpeg);base64,/'],
    ]);

    try{

            DB::beginTransaction();


    $biometricMap = [];

    if (!empty($data['receiver'])) {

        $pic = $data['receiver'][0]['picture'];

        $data['receiver'][0]['picture'] = $this->storeBase64Image($pic, 'receiver');
    }
    if (!empty($data['witness'])) {
                foreach ($data['witness'] as $key => $witness) {
                    if (!empty($witness['picture'])) {
                        $data['witness'][$key]['picture'] = $this->storeBase64Image(
                            $witness['picture'],
                            'witness'
                        );
                    }
                }
            }

            $inheritanceRecords = Inheritance::where('id',$data['requester_id'])->update(['is_current' => NULL]);

        foreach ($data['biometrics'] as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    if(!empty($value1)){

                        $bio = Biometric::create([
                            'cnic'        => $value1['cnic'],
                            'image'       => $this->storeBase64BiometricImage($value1['image'], $key, $value1['cnic']),
                            'code'        => $value1['code'],
                            'status'      => $value1['status'],
                            'template'    => $value1['template'],
                            'device_type' => $value1['deviceType'],
                            'timestamp'   => $value1['timestamp'] ?? now(),
                        ]);
                        $biometricMap[$value1['cnic']] = $bio->id;
                    }
                    }
            }

        foreach ($data['receiver'] as $receiver) {
                $biometricId = $biometricMap[$receiver['cnic']] ?? null;
                $inheritance = Inheritance::create([
                    'request_id'   => $data['request_id'],
                    'property_id'  => $data['property_id'],
                    'name'         => $receiver['name'],
                    'father_name'  => $receiver['father_name'],
                    'area'         => $receiver['area'],
                    'cnic'         => $receiver['cnic'],
                    'cnic_front'   => $receiver['cnic_front'],
                    'cnic_back'    => $receiver['cnic_back'],
                    'address'      => $receiver['address'] ?? null,
                    'picture'      => $receiver['picture'] ?? null,
                    'is_current'   => 1,
                    'biometric_id' => $biometricId, // 👈 key condition
                ]);

            }


            foreach ($data['witness'] as $seller) {
                $biometricId = $biometricMap[$seller['cnic']] ?? null;

                Witness::create([
                    'request_id'  => $data['request_id'],
                    'property_id'       => $data['property_id'],
                    'name'       => $seller['name'],
                    'father_name' => $seller['father_name'],
                    'cnic'       => $seller['cnic'],
                    'cnic_front' => $seller['cnic_front'],
                    'cnic_back'  => $seller['cnic_back'],
                    'address'    => $seller['address'] ?? null,
                    'picture'    => $seller['picture'],
                    'biometric_id'      => $biometricId,
                ]);
            }

            $path1 = $this->storeBase64Image($data['snapshot_step3'], 'statement');
            $path2 = $this->storeBase64Image($data['snapshot_step4'], 'statement');


            // Update e file
            TransferFile::where('id', $request->id)->update([
                'seller_declaration' => $path1,
                'buyer_declaration' => $path2,
            ]);

            $property = Property::findOrFail($request->property_id);
            $req = TransferFile::findOrFail($request->id);

            $reque     = Requests::findOrFail($req->request_id);
            // Store latest transfer type
            $property->latest_transfer = $reque->request_type;
            $property->warasat_count = ($property->warasat_count ?? 0) + 1;
                // dd($property,($property->warasat_count ?? 0) + 1);
            $property->save();

            Requests::where('id', $data['request_id'])->update([
                'dd_action' => '1',
                'dd_id' => auth()->user()->id,
                'dd_action_date' => now()->format('Y-m-d'),
            ]);

            DB::commit();
       return redirect('/dd-transfer-list')->with('success', 'Property Transfered Successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Optional: Log the error
            \Log::error('Transaction failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Transaction failed. Nothing was saved.',
                'error' => $e->getMessage()
            ], 500);
        }



    }



    public function store(Request $request)
    {
    // dd($request->all());
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'request_id' => 'nullable|exists:requests,id',
            'document_type' => 'required|string|max:100',
            'file_path' => 'required|file|mimes:pdf,jpg,jpeg,png,docx|max:4096',
            'remarks' => 'nullable|string|max:255',
        ]);

        $folder = 'uploads/transfer_order';

        // make sure directory exists
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0777, true);
        }

        // create unique file name
        $filename = time() . '_' . $request->file('file_path')->getClientOriginalName();

        // move file manually to /public/uploads/property_documents
        $request->file('file_path')->move(public_path($folder), $filename);

        // get full relative path (like uploads/property_documents/1729690999_order.png)
        $path = $folder . '/' . $filename;

        PropertyDocument::create([
            'property_id' => $request->property_id,
            'request_id' => $request->request_id,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('success', 'Property document uploaded successfully!');
    }

    public function completedRequests()
    {

        $data = Requests::with('documents')
        ->where('dd_action', 1)
        ->whereHas('documents') // only requests having uploaded documents
        ->get();

        return view('DD.transferList', compact('data'));
    }

    public function uploadTransferOrder(Request $request,$id){
        $req = Requests::findOrFail($id);
        $property = Property::findOrFail($req->property_id);
        if($req->request_type == 1){
                $type = 'Transfer Order';
            }
            if($req->request_type == 2){
                $type = 'Warassat Order';
            }
            if($req->request_type == 3){
                $type = 'Hiba Order';
            }
        if($request->type == 1){

            $request->validate([
                'screenshot'=> 'required',
            ]);


        $imageData = $request->screenshot;
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);

        // Create unique file name
        $fileName = 'screenshot_' . Str::uuid() . '.png';

        // Define folder path
        $folderPath = public_path('uploads/transfer_order');

        // Create folder if it doesn't exist
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Full file path
        $filePath = $folderPath . '/' . $fileName;

        // Save the file
        file_put_contents($filePath, $image);

        // Save record in DB (relative path for easy use)
        PropertyDocument::create([
            'property_id' => $req->property_id,
            'request_id' => $req->id,
            'document_type' => $type,
            'file_path' => 'uploads/transfer_order/' . $fileName, // relative to public
        ]);
        $property->allotment_type = 'transferred';
        $property->latest_transfer = $req->request_type;
        $property->save();

        }
        else{
            $request->validate([
                            'transfer_order'=> 'required',
                        ]);

            $file = $request->file('transfer_order');

        // Define folder path
        $folderPath = public_path('uploads/transfer_order');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Create unique filename
        $fileName = 'transfer_order_' . $id . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Move file to public/uploads/transfer_orderss
        $file->move($folderPath, $fileName);

        // Full path
        $fullPath = $folderPath . '/' . $fileName;

        // Save record in DB
        PropertyDocument::create([
            'property_id' => $req->property_id,
            'request_id' => $id,
            'file_path' => $fullPath,
            'document_type' => $type, // optional
        ]);
        $property->allotment_type = 'transferred';
        $property->latest_transfer = $req->request_type;
        $property->save();
        }

        return redirect()->route('completedRequests');

    }
    public function transferOrderStatementList(){
        $data = Requests::with('statement')
        ->where('dd_action', 1)
        ->get();

        return view('DD.transferList', compact('data'));
    }

    public function generateTransferOrderStatement($id){
        $property = Requests::findOrFail($id);
        if($property->request_type == 2){
            return $this->generateWarassatOrderStatement($id);
        }
        $data = Requests::with(['property.owners','participants.owner','transfer','transferAttaches','dummyreceiver'])->where('id',$id)->first();

        $receiver = $data->dummyreceiver->pluck('cnic')->toArray();
        $ownersNotReceivers = [];
        $i = 0;

        foreach ($data->property->owners as$key => $owner) {
            if (!in_array($owner->cnic, $receiver)) {
                $ownersNotReceivers[$i]['name'] = $owner->name;
                $ownersNotReceivers[$i]['father_name'] = $owner->father_name;
                $previousOwner[] = $owner->cnic;
                $i++;
            }
        }


        foreach($data->participants as $owner ){

            $ownersNotReceivers[$i]['name'] = $owner->owner->name;
            $ownersNotReceivers[$i]['father_name'] = $owner->owner->father_name;
            $previousOwner[] = $owner->owner->cnic;
            $i++;
        }
        // dd($ownersNotReceivers);

            $ownersWhoMadeRequest = [];
            foreach ($data->participants as $participant) {
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
        return view('DD.drafts.generateTransferOrderStatement', compact('data','ownersNotReceivers','allOwnersMadeRequest','singleOwner','multipleRequest'));
    }

    private function generateWarassatOrderStatement($id){

        $data = Requests::with(['property.owners','participants.owner','transfer','transferAttaches','dummyreceiver'])->where('id',$id)->first();

        $receiver = $data->dummyreceiver->pluck('cnic')->toArray();
        $ownersNotReceivers = [];
        $i = 0;

        foreach ($data->property->owners as$key => $owner) {
            if (!in_array($owner->cnic, $receiver)) {
                $ownersNotReceivers[$i]['name'] = $owner->name;
                $ownersNotReceivers[$i]['father_name'] = $owner->father_name;
                $previousOwner[] = $owner->cnic;
                $i++;
            }
        }


        foreach($data->participants as $owner ){

            $ownersNotReceivers[$i]['name'] = $owner->owner->name;
            $ownersNotReceivers[$i]['father_name'] = $owner->owner->father_name;
            $previousOwner[] = $owner->owner->cnic;
            $i++;
        }
        // dd($ownersNotReceivers);

            $ownersWhoMadeRequest = [];
            foreach ($data->participants as $participant) {
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
        return view('DD.drafts.generateWarassatOrderStatement', compact('data','ownersNotReceivers','allOwnersMadeRequest','singleOwner','multipleRequest'));

    }

}

