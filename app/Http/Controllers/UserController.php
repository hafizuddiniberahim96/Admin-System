<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use  App\Models\User_roles as Roles;
use  App\Models\User_details as UserDetails;
use  App\Models\User_occupation as Occupation;
use  App\Models\User;
use  App\Models\State;
use  App\Models\Region;
use App\Models\Institution_status;
use  App\Models\Document_upload as Upload;
use Helmesvs\Notify\Facades\Notify;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth.lock');

    }

    public function index(){
        if (Auth::check()){
            $status = Auth::user()->registerComplete;
            $isApproved = Auth::user()->isApproved;
            if (!$status || !$isApproved){
                Notify::error("Account currently pending at admin approval", "Alert",["closeButton" => true]);
                return redirect('account-pending');
            } 

            return view('dashboard')
                        ->withSuccess('Signed in');
        }        
       
    }

    public function profile(){
        if(Auth::check()){
            $user =Auth::User();
            $usercollection = User::getUser($user);
            $instcollection = Institution_status::where('isApproved',1)->get();
            //check if users did upload nric before
            $nric_pdf = Upload::retrieve_file('users',$user->_id)->first();

            // return Auth::user()->mentee->mentor;


            if(in_array(Auth::user()->role->name,['student','entrepreneur'])){
                $mentorcollection = (Auth::user()->mentee) ? collect(Auth::user()->mentee->mentor->details) : collect();
            }
            else{
                $mentorcollection = collect();
            }


            return view('user.user-profile')->with('user',$usercollection)
                                            ->with('states',State::get())
                                            ->with('nric_file',collect($nric_pdf))
                                            ->with('institutions', $instcollection)
                                            ->with('mentor', $mentorcollection)
                                            ->withSuccess('You have signed-in');
        }
        Notify::error("You are not allowed to access.", "Alert",["closeButton" => true]);
        return redirect("login")->withSuccess('You are not allowed to access');
    } 

    public function updateProfile(Request $request, $id){

       $data =$request->validate([
        'fullName' => 'required',
        'phoneNumber' => 'required',
        'dateofbirth' => 'required',
        'address' => 'required',
        'state_id' => 'required',
        'region_id' => 'required',
        'postcode' => 'required',
        ]);

        $user = User::where('_id',$id)->firstOrFail();
        if(!$user->registerComplete){
            $results = User::updateUser($request,$id);
            Notify::success("Successfully submit your profile. Please wait for admin approval.", "Success",["closeButton" => true]);
            return redirect('account-pending');
        }

        if(($user->registerComplete == 1) AND ($user->isApproved == 1)){
            Notify::success("Successfully update user profile.", "Success",["closeButton" => true]);
            $results = User::updateUser($request,$id);
            return redirect()->back();    
        }

        $results = User::updateUser($request,$id);
        Notify::success("Successfully submit your updated profile. Please wait for admin approval.", "Success",["closeButton" => true]);
        return redirect('account-pending');
    
    }


    public function getRegion(Request $request){
        $region = Region::where('state_id', $request->state_id)->get();
        return $region;
    }

    public function userDetail($id){
        
        $user = User::findOrFail($id);
        $usercollection = User::getUser($user);
        //check if users did upload nric before
        $nric_pdf = Upload::retrieve_file('users',$user->_id)->first();

        if(in_array($usercollection['role'],['student','entrepreneur'])){
            $mentorcollection = ($user->mentee) ? collect($user->mentee->mentor->details) : collect();
        }
        else{
            $mentorcollection = collect();
        }
        $institutions  = Institution_status::where('isApproved',1)->get();

        return view('eusahawan.user.detail')->with('user',$usercollection)
                                            ->with('states',State::get())
                                            ->with('mentor', $mentorcollection)
                                            ->with('nric_file',collect($nric_pdf))
                                            ->with('institutions',$institutions);
    }
    

    public function updateInstitutionIstutor(Request $request,$id){

        
        $data = $request->validate([
            'institution_id' => 'required',
            ]);
        $user = User::where('_id',$id)->firstOrFail();
        $user->update(["institution_id" =>$data["institution_id"]]);

        if(Auth::user()->role->name == 'admin'){
            Notify::success("Successfully update institution.", "Success",["closeButton" => true]);
            return redirect('mye-usahawan/' . $user->role->name .'/' . $id);
        }
        else{
            
            Notify::success("Successfully update your institution.", "Success",["closeButton" => true]);
            return redirect('mye-usahawan/my-institution');
        }
    }



   
}
