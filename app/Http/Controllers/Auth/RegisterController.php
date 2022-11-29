<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\User_roles as Roles;
use Helmesvs\Notify\Facades\Notify;


class RegisterController extends Controller
{
    //

    public function Register(Request $request)
    {  
        $request->validate([
            'nric' => 'required|numeric',
            'email' => 'required|email',
            'roles' => 'required',
            'password' => 'min:6|required_with:confirmpassword|same:confirmpassword',
            'confirmpassword' => 'min:6',            
        ]);
           
        $data = $request->all();
        $check = $this->create($data);


        if($check) return redirect("verify-email/".$check);
        else return redirect("sign-up");
    }

    public function registration()
    {
        $roles = Roles::select('_id as id', 'name')->where('name', '<>', 'admin')->get();
        return view('auth.signUp')->with('roles',$roles);
    }

    public function create(array $data)
    {
        $user = User::where([
            ['nric', '=', $data['nric']],
            ['roles_id', '=', $data['roles']],
         ])->first();

        if ($user ==null){
            $user = User::create([
                'nric' => $data['nric'],
                'email' => $data['email'],
                'roles_id' => $data['roles'],
                'isActive' => 0,
                'registerComplete' => 0,
                'isApproved' => 0,
                'lockout_time' => 0,
                'password' => Hash::make($data['password'])
            ]);
            Notify::success("Successfully create user. Please verify your email.", "Success",["closeButton" => true]);

            return $user->_id;
        }else{
            Notify::error("User already exist!", "Error",["closeButton" => true]);
            return false;
        }
     
    } 

    public function registerAdmin(Request $request){
        $request->validate([
            'nric' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'min:6|required_with:confirmpassword|same:confirmpassword',
            'confirmpassword' => 'min:6',            
        ]);

        $admin =Roles::select('_id as id',)->where('name', 'admin')->first();
        $user = User::where([
            'nric' => $request->nric,
            'email' => $request->email,
            'roles_id'=> $admin['_id'],
         ])->first();

         if ($user ==null){
            $user = User::create([
                'nric' => $request->nric,
                'email' => $request->email,
                'roles_id' => $admin['_id'],
                'isActive' => 1,
                'registerComplete' => 1,
                'isApproved' => 1,
                'lockout_time' => 1,
                'password' => Hash::make($request->password)
            ]);
            return back()->withSucess('New Admin is Added!!');

        }else{
            return back()->with('errors','User already Exist!');
        }
    }
}
