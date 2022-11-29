<?php

namespace App\Http\Controllers;

use  App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use  App\Models\State;
use  App\Models\Region;
use  App\Models\User_roles as Roles;
use  App\Models\User_details as Details;
use  App\Models\Institution_status;
use  App\Models\System_settings;
use  App\Models\Supervision;

use Hash;
use Illuminate\Support\Facades\Route;
use Helmesvs\Notify\Facades\Notify;



class AdminController extends Controller
{
    //

    public function __construct(DocumentController $filetransfer){
       $this->filetransfer = $filetransfer;
       $this->id = Roles::where('name','admin')->first()['_id'];
       $this->middleware('auth');
       $this->middleware('auth.lock');
     
    }

     //*************Pending User Action************************* */
    public function pendingUser(){
        
        return view('eusahawan.user.pending')
        ->with('roles', Roles::where('name','<>','admin')->get());
    }

    public function AdminActionUser($action,$user_id){

        if ($action == 'approve'){
            User::where('_id',$user_id)->update(['isApproved'=> 1]);
            Notify::success("Successfully approve user.", "Success",["closeButton" => true]);

        } 
        else if($action == 'reject'){
            User::where('_id',$user_id)->update(['isApproved'=> 1,'registerComplete'=> 0]);
            Notify::success("Successfully reject user.", "Success",["closeButton" => true]);

        } 
        else if($action == 'cancel') {
            User::deleteRecord($user_id);
            Notify::success("Successfully cancel user.", "Success",["closeButton" => true]);
        }

        return redirect('/mye-usahawan/pending-user');
    }

    public function listPendingUser(){

        $users = User::where('isActive',1)
                        ->where('registerComplete',1)
                        ->where('isApproved',0)->get();

        $usercollection = collect($users);

        $users= $usercollection->map(function($user) use ($usercollection){

            return [
                'id' => $user->_id,
                'fullName' => ucwords($user->details->fullName),
                'nric'=> $user->nric,
                'roles' => ucwords($user->role->name),
                'email' => $user->email,
                'state' => collect($user->details->state)->get('name'),
                'region'=> collect($user->details->region)->get('name'),
            ];
            
        }); 
        return DataTables::of($users)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="Approve" href="/mye-usahawan/admin-action/approve/{{$id}}">
            <i class="fa fa-check"></i>
        </a>  
        <a  class="btn btn-labeled btn-warning" type="button"  data-placement="top" title="Reject"  data-title="Reject"   data-toggle="modal" data-target="#confirm-delete" data-value="{{$fullName}},{{$nric}}" data-href="/mye-usahawan/admin-action/reject/{{$id}}">
            <i class="fa fa-remove"></i>
        </a>  
        <a  class="btn btn-labeled btn-danger" type="button"  data-placement="top" title="Cancel" data-title="Cancel"  data-toggle="modal" data-target="#confirm-delete" data-value="{{$fullName}},{{$nric}}" data-href="/mye-usahawan/admin-action/cancel/{{$id}}">
            <i class="fa fa-trash"></i>
        </a>
        ')->make(true);
    }

    //****************Active Users Action*****************************/
    public function activeUsers(){
        $route_name = Route::currentRouteName(); 
        $role = substr($route_name, strrpos($route_name, '.' )+1);
        // return $role;
        if(in_array($role, array('student','entrepreneur')))
            return view('eusahawan.user.'.$role.'-active')->with('mentors',User::whereHas('role', function ($q){
                $q->whereIn('name',['teacher','instructor','secretariat']);
            })->where('registerComplete',1)->where('isApproved',1)->where('isActive',1)->get());

        return view('eusahawan.user.'.$role.'-active');
    }
    public function listUsers($role){

        $users = User::whereHas('role', function ($q) use ($role){
            $q->where('name',$role);
        })
        ->where(['isApproved' =>1,
                 'registerComplete'=>1])
        ->get();

        $usercollection = collect($users);
        $users= $usercollection->map(function($user) use ($usercollection){
                   $data = array();
                    if (in_array($user->role->name, array('student','teacher','instructor'),true)) {
                        $data['institution'] = ($user->institution ) ? $user->institution->name :'Not Assigned' ;
                    }
                    else if ($user->role->name == 'entrepreneur'){
                        $data['company'] = ($user->company) ? $user->company->name :'No Company Name' ;
                        $data['sector'] = ($user->company) ? $user->company->sector->name :'No Sector' ;
                        $data['state_company'] = ($user->company) ? $user->company->state->name :'No State' ;
                        $data['region_company'] = ($user->company) ? $user->company->region->name :'No Region' ;
                        $data['created_at'] = ($user->company) ? $user->company->dateEstablished : 0000;

                    }
                    $data=array_merge($data,
                    [
                            'id' => $user->_id,
                            'fullName' => ucwords($user->details->fullName),
                            'nric'=> $user->nric,
                            'email' => $user->email,
                            'state' => collect($user->details->state)->get('name'),
                            'region'=> collect($user->details->region)->get('name'),
                            'role' => $user->role->name,
                            'mentor_id' => ($user->mentee) ? $user->mentee->mentor_id : '',
                            'mentor_name' => ($user->mentee) ? $user->mentee->mentor->details->fullName : ''
                     ]);
                    return $data;
                            
        });


        return DataTables::of($users)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action','
        <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/mye-usahawan/{{$role}}/{{$id}}">
            <i class="fa fa-eye"></i>
        </a>
        @if(in_array($role,["student","entrepreneur"]))
        <a  class="btn btn-labeled btn-success text-white" type="button"  data-placement="top" data-title="Assign" data-toggle="modal" data-target="#assign-mentor" data-value="{{$fullName}}" data-id="{{$mentor_id}}" data-mentor="{{$mentor_name}}" data-href="/mye-usahawan/assign-supervision/{{$id}}">
            <i class="fa fa-user"></i>
        </a>  
        @endif
        ')
        ->make(true);

    }

    /******************Institution Pending Action************ */
    public function pendingInstitution(){
        return view('eusahawan.institution.pending');
    }

    public function listPendingInstitution(){

        $institutions = Institution_status::where('isApproved',0)->get();

        $institutecollection = collect($institutions);
        $institutions= $institutecollection->map(function($institute) use ($institutecollection){
                                                $data=
                                                    [
                                                            'id' => $institute->_id,
                                                            'name' => ucwords($institute->institution->name),
                                                            'type' => $institute->institution->type,
                                                            'createdBy' => $institute->user->details->fullName,
                                                            'postcode'=> $institute->institution->postcode,
                                                            'state' => collect($institute->institution->state)->get('name'),
                                                            'region'=> collect($institute->institution->region)->get('name')
                                                    ];
                                                
                                                    return $data;
                            
        });
        return DataTables::of($institutions)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="Approve" href="/mye-usahawan/admin-action/institute/approve/{{$id}}">
            <i class="fa fa-check"></i>
        </a>  
        <a  class="btn btn-labeled btn-warning" type="button"  data-placement="top" data-title="Reject"  data-toggle="modal" data-target="#confirm-delete" data-value="{{$name}}" data-href="/mye-usahawan/admin-action/institute/reject/{{$id}}">
            <i class="fa fa-remove"></i>
        </a>  
        <a  class="btn btn-labeled btn-danger" type="button"  data-placement="top" data-title="Cancel" data-toggle="modal" data-target="#confirm-delete" data-value="{{$name}}" data-href="/mye-usahawan/admin-action/institute/cancel/{{$id}}">
            <i class="fa fa-trash"></i>
        </a>
        ')->make(true);

    }

    public function assignSupervision(Request $request, $id){
        if(Supervision::where("mentee_id",$id)->first()){
            Notify::error("User already been assigned mentor.", "Fail",["closeButton" => true]);
            return back();
        }

        Supervision::create([
            "mentor_id" => $request->mentor_id,
            "mentee_id" => $id
        ]);
        Notify::success("Successfully assign mentor.", "Success",["closeButton" => true]);

        return back();

    }

    public function listActiveInstitution(){

        $institutions = Institution_status::where('isApproved',1)->get();

        $institutecollection = collect($institutions);
        $institutions= $institutecollection->map(function($institute) use ($institutecollection){
                    $data=
                    [
                            'id' => $institute->institution->_id,
                            'name' => ucwords($institute->institution->name),
                            'type' => $institute->institution->type,
                            'createdBy' => $institute->user->details->fullName,
                            'postcode'=> $institute->institution->postcode,
                            'state' => collect($institute->institution->state)->get('name'),
                            'region'=> collect($institute->institution->region)->get('name')
                     ];
                    return $data;
                            
        });

        return DataTables::of($institutions)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action','
        <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/mye-usahawan/institution/{{$id}}">
            <i class="fa fa-eye"></i>
        </a>')
        ->make(true);
        

    }

    public function AdminActionInstitute($action,$id){

        if ($action == 'approve'){
            Institution_status::find($id)->update(['isApproved'=> 1]);
            Notify::success("Successfully approve .", "Success",["closeButton" => true]);
        } 
        else if($action == 'reject'){
            Institution_status::find($id)->update(['isApproved'=> -1]);
            Notify::success("Successfully reject institution.", "Success",["closeButton" => true]);
        } 
        else if($action == 'cancel') {
            Institution_status::deleteRecord($id);
            Notify::success("Successfully cancel institution.", "Success",["closeButton" => true]);

        }
        return redirect("mye-usahawan/pending-institution");
    }

    /*******************Administrative tools  Settings */

    public function systemSettings(){
        $states=State::get();
        return view('admin.system_settings')->with('states',$states);
    }

    public function createSystemSettings(Request $request){
      $data =$request->validate([
            'tableName' => 'required',
            'name' => 'required',
        ]);
        if($request->tableName == 'State') State::create(['name' => $request->name]);
        else if($request->tableName == 'Region'){ 
            Region::create([
                'state_id' => $request->state_id,
                'name' => $request->name
            ]);
        }
        else System_settings::create($data);

        Notify::success("Successfully create item in " . strtolower($request->tableName) . ".", "Success",["closeButton" => true]);

        return redirect('admin-tools/system-settings');
    }

    public function listSystemSettings($tableName){

       if($tableName == 'state') $data = State::orderBy('created_at','DESC')->get();
       else if ($tableName =='region') {
           $data = Region::get();
       }
       else $data = System_settings::where('tableName',$tableName)->orderBy('created_at','DESC')->get();
       $datacollection = collect($data);
       $data = $datacollection->map(function($datum) use ($datacollection,$tableName){
           
                    $data=
                    [
                            'id' => $datum->_id,
                            'name' => ucwords($datum->name),
                            'created_at' => $datum->created_at->format('d/m/Y H:i:s A'),
                     ];
                     if($tableName =='region') $data['state'] = $datum->state->name;
                    return $data;
                            
        });
       return DataTables::of($data)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        <a  class="btn btn-labeled btn-danger" type="button"  data-placement="top" data-title="Cancel"  href="/admin-tools/delete-system-settings/'.$tableName.'/{{$id}}">
            <i class="fa fa-trash"></i>
        </a>
        ')->make(true);

    }


    public function deleteSystemSettings($category,$id){
        if($category == 'state') State::find($id)->delete();
        else if ($category == 'region') Region::find($id)->delete();
        else System_settings::find($id)->delete(); 

        Notify::error("Delete item in " . strtolower($category) . ".", "Delete",["closeButton" => true]);
        return back()->with('message', "Delete Successfull");
    }


    public function listAdmin(){
        return view('admin.index');
    }

    public function getlistAdmin(){
        $users = User::whereHas('role', function ($q){
            $q->where('name','admin');
        })
        ->get();

        $usercollection = collect($users);
        $users= $usercollection->map(function($user) use ($usercollection){
                   $data = array();
                    $data=array_merge($data,
                    [
                            'id' => $user->_id,
                            'fullName' => ucwords($user->details->fullName),
                            'nric'=> $user->nric,
                            'email' => $user->email
                     ]);
                    return $data;
                            
        });
        return DataTables::of($users)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action','
        <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/admin-tools/admin/{{$id}}">
            <i class="fa fa-edit"></i>
        </a>')
        ->make(true);
    }

    public function createAdminView(){
         return view('admin.create-admin');
    }
    public function createAdmin(Request $request){
        // return $request->only('email');
        $request->validate([ 'password' => 'min:6|required_with:confirmpassword|same:confirmpassword' ]);
        $admin=$request->validate([
            'nric' => 'required|numeric',
            'email' => 'required|email',
        ]);

        $admin_details =$request->validate([
            'fullName' => 'required',
            'dateofbirth' => 'required',
            'phoneNumber' => 'required',       
        ]);
        
        
       if(!User::where([$request->only('email')])->where('roles_id',$this->id)->first()){
        $user = User::create([
            'nric' => $request->nric,
            'email' => $request->email,
            'roles_id' => $this->id,
            'isActive' => 1,
            'registerComplete' => 1,
            'isApproved' => 1,
            'lockout_time' => 1,
            'password' => Hash::make($request->password)
        ]);
        Details::create(array_merge(['user_id'=>$user['_id']],$admin_details));
        if($request->file('profileImg')) $this->filetransfer->upload_profileImg($request->file('profileImg'),$user['_id']);

        Notify::success("Successfully create new admin.", "Success",["closeButton" => true]);

        return redirect('/admin-tools/list-admin');


        }
        else{
            Notify::error("Error create new admin", "Error",["closeButton" => true]);
            return redirect('/admin-tools/list-admin');

        }
    
    }

    public function viewAdmin($id){
        $route_name = Route::currentRouteName(); 
        $action = substr($route_name, strrpos($route_name, '.' )+1);
        $user = User::findOrFail($id);

        $collection = collect($user);
        $collection= $collection->merge(collect([
            'role' => $user->role->name
        ]));
        $collection = $collection->merge(collect($user->details)->map(function($details){
            return $details;
        }));
        
        return view('admin.update-admin')->with('user',$collection)
                                        ->with('action',($action =='update') ? '' : 'readonly');
    }

    public function updateAdmin(Request $request){
        $request->validate([ 'password' => 'min:6|required_with:confirmpassword|same:confirmpassword' ]);
        $admin=array_merge(
        ['roles_id'=> $this->id],
        $request->validate([
            'nric' => 'required|numeric',
            'email' => 'required|email',
        ]));

        User::where($admin)->update([ 'password' => Hash::make($request->password)]);
        return back()->with('message','Admin Password Changed !');
    }
    
    /*************Financing System Settings *****************/
    public function financeSettings(){
        return view('admin.finance-setting');
    }
    public function listFinanceSettings($tableName){

        $data = System_settings::where('tableName',$tableName)->orderBy('created_at','DESC')->get();
        $datacollection = collect($data);
        $data = $datacollection->map(function($datum) use ($datacollection,$tableName){
            
                     $data=
                     [
                             'id' => $datum->_id,
                             'name' => ucwords($datum->name),
                             'created_at' => $datum->created_at->format('d/m/Y H:i:s A'),
                      ];
                     return $data;
                             
         });
        return DataTables::of($data)
         ->escapeColumns([])
         ->addIndexColumn()
         ->addColumn('action', '
         <a  class="btn btn-labeled btn-danger" type="button"  data-placement="top" data-title="Cancel"  href="/admin-tools/delete-system-settings/'.$tableName.'/{{$id}}">
             <i class="fa fa-trash"></i>
         </a>
         ')->make(true);
 
     }

     public function createFinanceSettings(Request $request){
        $data =$request->validate([
              'tableName' => 'required',
              'name' => 'required',
          ]);
          System_settings::create($data);
          return redirect('admin-tools/finance-settings');
      }
}
