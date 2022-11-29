<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\User_roles as Roles; 
use Carbon\Carbon; 
use Helmesvs\Notify\Facades\Notify;

use Mail; 
use Hash;
use DB;
use Illuminate\Support\Str;


use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    //
    public function __construct()
    {
        $this->roles=Roles::select('_id as id', 'name')->where('name', '<>', 'admin')->get();
    }
    public function forgotPassword()
    {
        if(!Auth::check()){
        
            return view('auth.forgotPassword')->with('roles',$this->roles);
        } 
        else return redirect('home');
    }

    public function submitForgetPassword(Request $request){

        $request->validate([
            'nric' => 'required|exists:users',
            'roles' => 'required'
        ]);


        $token = Str::random(64);
        $data = User::where('roles_id', $request->roles)
                        ->where('nric',$request->nric)->select('email')->first();

        // Checking if nric exist but category selected has no matched
        if(empty($data)){
            Notify::error("NRIC and category selected has no email matched.", "Error",["closeButton" => true]);
            return view('auth.forgotPassword')->with('roles',$this->roles);
        }
        $email= $data->email;

        DB::table('password_resets')->insert([
            'nric' => $request->nric,
            'role_id'=> $request->roles,
            'token' => $token, 
          ]);

          Mail::send('email.forgetPassword', ['token' => $token], function($message) use($email){
            $message->to($email);
            $message->subject('Reset Password');
        });
        $email = explode("@",$email);

        Notify::success("Successfully send email for reset password.", "Success",["closeButton" => true]);
        return view('auth.forgotPassword')->with('roles',$this->roles)->with('message', 'Your forgot password email has been sent to '. substr($email[0], 0, 3) . str_repeat("*",strlen($email[0]) - 3)  . '@' . $email[1]);
    }

    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
     }

     public function submitResetPasswordForm(Request $request)
      {
          
          $request->validate([
              'nric' => 'required|exists:users',
              'password' => 'required|string|min:6|required_with:confirmpassword|same:confirmpassword',
              'confirmpassword' => 'min:6'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'nric' => $request->nric, 
                                'token' => $request->token
                              ])
                              ->first();
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }

        $user = User::where('nric', $request->nric)->where('roles_id',$updatePassword['role_id'])
        ->update(['password' => Hash::make($request->password), 'isActive' => 1]);
        
        if($user){
            DB::table('password_resets')->where(['nric'=> $request->nric])->delete();
            Notify::success("Successfully reset your password.", "Success",["closeButton" => true]);
            return redirect('/login');
        }
        else{
            Notify::error("Error in reset password. Please contact admin.", "Error",["closeButton" => true]);
        }

        return redirect()->back();

      }
 
}
