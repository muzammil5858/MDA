<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginBiometric;
use App\Models\Institute;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Ramsey\Collection\Collection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    // public function alltehsils(Request $request,$id){
    //     // $data = Institute::where('district_id',$id)->get();
    //     return \response()->json($data);
    // } 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function store(Request $request)
        {
            
            
            $data = $this->validate($request, [
                'name' => 'required',
                'email' => 'nullable',
                'password' => 'required|same:confirm-password',
                'roles' => 'required',
                'cnic' => 'required',
                'phoneno' => 'required|size:11',
                'town' => 'required',
                
            ]);
            
            
        
            $input = $data;
            $input['town'] = json_encode($request->town);
            if(auth()->user()->hasRole('front-desk')){
                $input['source'] = 'fd-'.auth()->user()->id;
            }
            
            
            $input['password'] = Hash::make($input['password']);
            
            
        
            $user = User::create($input);
            if (!empty($request->biometric)) {
                $bio = collect(json_decode($request->biometric))->first();
                // dd($biometric);
                        LoginBiometric::create([
                'cnic'        => $bio->cnic,
                'image'       => $bio->image,
                'code'        => $bio->code,
                'template'    => $bio->template,
                'device_type' => 'Secugen',
                'status'      => $bio->status,
                'timestamp'   => $bio->timestamp,
            ]);

    }
            $user->assignRole($request->input('roles'));
            if(auth()->user()->hasRole('front-desk')){
            return redirect()->route('fd.index')
                            ->with('success','User created successfully');  
            }
            return redirect()->route('users.index')
                            ->with('success','User created successfully');
        }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        
        $roles = Role::pluck('name','name')->all();
        // dd($roles);
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => '',
            'roles' => 'required',
            'cnic' => 'required',
            'town' => 'required',
        ]);
    
        $input = $request->all();
        // dd($input);
        $user = User::find($id);
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input['password'] = $user->password;    
        }
        $input['town'] = json_encode($request->town);
        
        
        $some = $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'cnic' => $input['cnic'],
            'town' => $input['town'],
            'password' => $input['password'],
        ]);
    
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        if(auth()->user()->hasRole('front-desk')){

            return redirect()->route('fd.index')
                            ->with('success','User updated successfully');
        }
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}