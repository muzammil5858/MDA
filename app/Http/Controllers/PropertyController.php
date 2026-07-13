<?php

namespace App\Http\Controllers;

use App\Models\Attchement;
use App\Models\Inheritance;
use App\Models\Property;
use Illuminate\Http\Request;
use DB;

class PropertyController extends Controller
{
    public function create(){
        $property = DB::table("temp_properties")->where('user_id',auth()->user()->id)->first();
        return view('property.form',compact('property'));
    }
    public function store(Request $request){
        // dd($request->all());
        
        // First validation for properties
        $data = $request->validate([
            "district" => '',
            "center" => '',
            "locality" => '',
            "code" => 'required|unique:properties',
            "dm_acre" => '',
            "dm_kanal" => '',
            "dm_marla" => '',
            "dm_sqrft" => '',
            "category" => '',
            "acre" => '',
            "kanal" => '',
            "marla" => '',
            "sqrft" => '',
            "alotment_order" => '',
            "alotment_date" => '',
            "plot_no" => '',
            "evacue_owner" => '',
            "com_date" => '',
            "allotee_name" => '',
            "relation" => '',
            "cnic" => '',
            "hiba_count" => '',
            "warasat_count" => '',
            "sale_count" => '',
        ]);
        
        
        $data['user_id'] = auth()->user()->id;
        
        
        // Second validation for attachments
        $request->validate([
            'complete_file' => 'required',
            'affected_house' => '',
            'builtup_property' => '',
            'entitlement' => '',
            'allot_com' => '',
            'allot_order' => '',
            'chit_mapping' => '',
            'order_attach' => '',
        ]);
        
        // Fetch temp_attachment data
        $temp_attach = DB::table('temp_attchements')->where('user_id', auth()->user()->id)->first();
        
        
        if (!$temp_attach) {
            return redirect()->back()->with('error', 'No temporary attachment found for this user.');
        }
        DB::beginTransaction();
        
        try {
            $property = Property::create($data);
            // Convert to array, add `property_id`
            unset($temp_attach->created_at, $temp_attach->updated_at, $temp_attach->id, $temp_attach->user_id);
            $temp_attach = (array) $temp_attach;
            $temp_attach['property_id'] = $property->id;
            
            // Insert into Attachments model
            Attchement::create($temp_attach);
            
            DB::commit();
    }
    catch (\Exception $e) {
        // Rollback the transaction if there's an error
        DB::rollBack();
       
        
        // Handle the exception or return an error
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }

        // Delete temporary entries
        DB::table('temp_properties')->where('user_id', auth()->user()->id)->delete();
        DB::table('temp_attchements')->where('user_id', auth()->user()->id)->delete();

        // Commit the transaction if everything is successful

        return redirect()->route('formList')->with('success', 'Property and attachments successfully saved.');
    

        
        



    }
    private function attachements($file,$key){
        $location = [
            'complete_file' => '/uploads/complete',
            'affected_house' => '/uploads/affected_house',
            'builtup_property' => '/uploads/builtup',
            'entitlement' => '/uploads/entitlement',
            'allot_com' => '/uploads/allotment_committee',
            'allot_order' => '/uploads/allotment_order',
            'chit_mapping' => '/uploads/chit_mapping', 'order_attach' => '/uploads/order_attchement',
          
        ];
       $originalName = $file->getClientOriginalName(); 
        $timestamp = now()->timestamp; 
        $filename = $timestamp . '_' . $originalName;// Get the original file name

        // Check if it's an image or a PDF based on the mime type
        if (in_array($file->getClientMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'])) {
            // Move the file to the respective folder based on the $key
            $file->move(public_path($location[$key]), $filename);

            return $filename; // Return the file name for further use
        } else {
            // Optionally handle unsupported file types
            throw new \Exception("Unsupported file type. Only images and PDFs are allowed.");
        }

    }

    public function tempStore(Request $request){
            
            if($request->current == '1'){


                    $userId = auth()->user()->id;
                $record = DB::table('temp_properties')->updateOrInsert(
                    ['user_id' => $userId], // Condition
                    [$request->name => $request->value] // Dynamic column name and value
                );
            }
            else{
                $userId = auth()->user()->id;
                
                
                if($request->hasFile('value')){
                    
                    $file = $this->attachements($request->value,$request->name);
                }
                $record = DB::table('temp_attchements')->updateOrInsert(
                    ['user_id' => $userId], // Condition
                    [$request->name => $file] // Dynamic column name and value
                );

            }
            return response()->json(['status' => 'Data added to temp successfully']);

            
    }
    public function tempFileStore(Request $request){
        
        $personalId = $request->id ;
                
                
        if($request->hasFile('value')){
            
            $file = $this->attachements($request->value,$request->name);
        }
        $record = DB::table('attchements')->updateOrInsert(
            ['property_id' => $personalId], 
            [$request->name => $file] 
        );

    
         return response()->json(['status' => 'Data added to temp successfully']);
    }

    public function formList(){
        $data = DB::table('properties')->whereNull('de_date')->get();

        return view('property.formlist',compact("data"));
    }
    public function entryList(){
        $data = DB::table('properties')->where('deo',auth()->user()->id)->whereNotNull('de_date')->get();
        
        return view('property.formlist',compact("data"));
    }
    public function formEdit($id){
        $property = Property::with('attachment')->where('id',$id)->first();
        $inherit = Inheritance::where('property_id',$property->id)->get();
       
        
        return view('property.form-edit',compact('property','id','inherit'));
    }
    public function formDetail($id){
        $property = Property::with('attachment','owners')->where('id',$id)->first();
        
     
        
        return view('property.formDetail',compact('property','id'));
    }
  public function update(Request $request, $id)
{
    
    $property = Property::findOrFail($id);

    $data = $request->validate([
        'district' => 'required',
        'center' => 'required',
        'locality' => 'required',
        'code' => [
            'required',
            $request->code != $property->code ? 'unique:properties,code' : '',
        ],
        'dm_acre' => '',
        'dm_kanal' => '',
        'dm_marla' => '',
        'dm_sqrft' => '',
        'category' => '',
        'acre' => '',
        'kanal' => '',
        'marla' => '',
        'sqrft' => '',
        'alotment_order' => '',
        'town' => '',
        'plot_no' => 'required',
        'evacue_owner' => '',
        'sector' => '',
        'allotee_name' => '',
        'relation' => '',
        'cnic' => '',
        'allotment_type' => '',
        'transfer_count' => '',
        "hiba_count" => '',
            "warasat_count" => '',
            "sale_count" => '',
            "qabza_chit" => '',
            "house_constructed" => '',
            "map_approval" => '',
            "owner_type" => '',
            "boundary_wall" => '',
            "latest_transfer" => '',
    
    ]);

    

    // Role: deo
    if (auth()->user()->hasRole('deo')) {
        if ($property->deo != null && $property->de_date != null) {
            $data['deo'] = $property->deo;
            $data['de_date'] = $property->de_date;
        } else {
            if ($request->category != null && $request->allotee_name != null) {
                $data['de_date'] = now()->format('d-m-Y');
                $data['deo'] = auth()->user()->id;
            }
        }
    }

 
    
  
    // Update property
    Property::where('id', $id)->update($data);
    
    

    if ($request->has('inheritance_null')) {
        // Single fallback record - update or create by property_id
        
        foreach ($request->inheritance as $id => $data) {
            $data['is_current'] = 1;
        Inheritance::updateOrCreate(
                    ['id' => $data['id']],
                    array_merge($data, ['property_id' => $property->id])
                );
    }

    } else {
       
        

        foreach ($request->inheritance as $id => $data) {
            $data['is_current'] = 1;
            if ($data['id']) {
                // Update existing record
               Inheritance::updateOrCreate(
                    ['id' => $data['id']],
                    array_merge($data, ['property_id' => $property->id])
                );
                $submittedIds[] = $id;
            } else {
                // Create new record
                $newRecord = Inheritance::create(
                    array_merge($data, ['property_id' => $property->id])
                );
                $submittedIds[] = $newRecord->id;
            }
        }

    }

    return redirect()->route('formList');
}
    public function formDelete($id){
                $delete = Property::find($id)->delete();
        $adelete = Attchement::where('property_id', $id);

        // Check if there are attachments to delete and delete them
        if ($adelete->exists()) {
            $adelete->delete();
        }
        return redirect()->back()->with('success','Entry Deleted Successfully.');
    }

    public function filesDetail($type){
        if($type == 'index'){

            $appdata = DB::select("SELECT count(properties.code) as entries,date(created_at) as date from properties  group by date(created_at) order by date(created_at) desc");
            $graph = DB::select("SELECT count(properties.code) as entries,date(created_at) as date from properties  where DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= date(created_at) group by date(created_at) order by date(created_at) desc ");
        
           
        }
        else if($type == 'entry'){

            $appdata = DB::select("SELECT count(properties.code) as entries,STR_TO_DATE(de_date, '%d-%m-%Y') as date from properties where de_date is not null AND category IS NOT NULL 
                  AND allotee_name IS NOT NULL group by date order by date desc");
            $graph = DB::select("SELECT count(properties.code) as entries,de_date as date from properties where de_date is not  null AND category IS NOT NULL 
                  AND allotee_name IS NOT NULL and DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= STR_TO_DATE(de_date, '%d-%m-%Y')  group by date order by date desc");

    
            
        }
        
        $labels = array_column($graph, 'date');
        
        $data = array_column($graph, 'entries');
        
        return view('qa.dailydetail', compact('data', 'appdata', 'labels','type'));
        
    }
    public function dailyDetail(Request $request){
        
        
        if ($request->type == 'index') {
            $data = DB::select("
            SELECT count(properties.code) as entries, users.name 
            FROM properties 
            LEFT JOIN users ON users.id = properties.user_id 
            WHERE DATE(properties.created_at) = '$request->date' 
            GROUP BY users.name
            ");
        } elseif ($request->type == 'entry') {
            $data = DB::select("
                SELECT count(properties.code) as entries, users.name 
                FROM properties 
                LEFT JOIN users ON users.id = properties.deo 
                WHERE STR_TO_DATE(de_date, '%d-%m-%Y') = '$request->date' 
                  AND category IS NOT NULL 
                  AND allotee_name IS NOT NULL 
                GROUP BY users.name
            ");
        }
            return response()->json($data);
    }

    public function deleteInheritance(Request $request,$id)
    {
         $inheritance = Inheritance::findOrFail($id);
         $inheritance->delete();

    return response()->json(['message' => 'Deleted successfully']);
    }

}
