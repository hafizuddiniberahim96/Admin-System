<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\State;
use  App\Models\User;
use  App\Models\Supervision;
use  App\Models\Institution;
use  App\Models\Institution_status;
use Illuminate\Support\Facades\Auth;
use Helmesvs\Notify\Facades\Notify;
use Yajra\DataTables\Facades\DataTables;
    


class InstitutionController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth.lock');

    }

    public function index(){
        return view('eusahawan.institution.institution-active');
    }

    public function myInstitution(){
        $user = Auth::user()->_id;

        $institutions = Institution_status::where('isApproved',1)->get();

        $institution = Institution::where('_id',Auth::user()->institution_id)->first();

        if($institution){
            return view('eusahawan.institution.my-institution')
            ->with('institution',$institution)
            ->with('institutions',$institutions);
        }

        $institution = Institution::whereHas('status', function ($q) use ($user){
            $q->where('created_by',$user);
        })->first();

        if($institution){
            return view('eusahawan.institution.my-institution')
            ->with('institution',$institution)
            ->with('institutions',$institutions);
        }

        

        return view('eusahawan.institution.my-institution')
        ->with('institution',[])
        ->with('institutions',$institutions);

        
    }

    public function registerInstitution(){
        return view('eusahawan.institution.register-institution')->with('states',State::get());
    }

    public function viewInstitution($id){
        $institution = Institution::where('_id',$id)->first();

        if(empty($institution)) abort(404);

        return view('eusahawan.institution.view-institution')->with('states',State::get())->with('institution', $institution);
    }

    public function updateInstitution(Request $request, $id){

        if($request->post()){
            $validatedData =$request->validate([
                'name' => 'required',
                'address' => 'required',
                'type' => 'required',
                'state_id' => 'required',
                'region_id' => 'required',
                'postcode' => 'required',
            ]);

            Institution::where('_id',$id)->update($validatedData);
            Institution_status::where('institution_id',$id)->update(['isApproved'=> 0]);
            Notify::success("Successfully update your institution information", "Success",["closeButton" => true]);
            return view('eusahawan.institution.view-institution')->with('states',State::get())->with('institution',Institution::where('_id',$id)->first());
        }
        $institution = Institution::where('_id',$id)->first();

        if(empty($institution)) abort(404);

        return view('eusahawan.institution.update-institution')->with('states',State::get())->with('institution', $institution);
    }

    public function createInstitution(Request $request){
        $validatedData =$request->validate([
            'name' => 'required',
            'address' => 'required',
            'type' => 'required',
            'state_id' => 'required',
            'region_id' => 'required',
            'postcode' => 'required',
        ]);

        $insert = Institution::create($validatedData);
        
        if($insert){
            $institution_id = $insert['_id'];
            Institution_status::create([
                'institution_id' => $institution_id,
                'created_by' => Auth::id(),
                'isApproved' => 0,

            ]);

            Notify::success("Successfully register your institution.", "Success",["closeButton" => true]);
            return redirect('/mye-usahawan/my-institution')->with('institution',$insert);
        }

    }

    public function listStudentTeacher($institution_id){
        $institudeUser = collect(User::where(['isApproved'=>1, 'registerComplete'=>1,'institution_id' => $institution_id])->get());
       
        $usercollection = $institudeUser->map(function($user) use ($institudeUser){

            return [
                'name' => ucwords($user->details->fullName),
                'nric' => $user->nric,
                'role' => ucwords($user->role->name),
                'phone' => $user->details->phoneNumber,
                'email' => $user->email,   
                'state' => $user->details->state->name,
                'region' => $user->details->region->name,
            ];
            
        });
        return DataTables::of($usercollection)
        ->escapeColumns([])
        ->addIndexColumn()
       ->make(true);

    }

    #********************** Supervisor***********************#
    public function viewSupervisor($role){
        if(!in_array($role,['student','entrepreneur'])){
            Notify::error("Unrecognize Action Method.", "Failed",["closeButton" => true]);
            return redirect('/home')->withErrors('Unrecognize Action Method.');
        }
        return view('eusahawan.supervisor.'.$role);
    }
    public function listSupervisor($role){
        if(!in_array($role,['student','entrepreneur'])){
            Notify::error("Unrecognize Action Method.", "Failed",["closeButton" => true]);
            return redirect('/home')->withErrors('Unrecognize Action Method.');
        }
        $supervision = collect(Supervision::where('mentor_id', Auth::id())->get());

        $usercollection = $supervision->map(function($user) use ($role){
            if($user->mentee->role->name == $role)  
                return [
                    'id' => $user->mentee->_id,
                    'name' => ucwords($user->mentee->details->fullName),
                    'nric' => $user->mentee->nric,
                    'phone' => $user->mentee->details->phoneNumber,
                    'email' => $user->mentee->email,   
                    'state' => $user->mentee->details->state->name,
                    'region' => $user->mentee->details->region->name,
                ];
            
        })->filter();

        return DataTables::of($usercollection)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action','
        <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/mye-usahawan/supervision-'.$role.'/{{$id}}">
            <i class="fa fa-eye"></i>
        </a>
        ')
        ->make(true);
        
    }
}
