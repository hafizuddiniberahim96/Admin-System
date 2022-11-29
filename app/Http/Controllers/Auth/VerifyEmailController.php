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

class VerifyEmailController extends Controller
{
    //
    public function __construct()
    {
        $this->roles=Roles::select('_id as id', 'name')->where('name', '<>', 'admin')->get();
    }

    public function verifyEmail($user_id){
        $user = User::find($user_id);
        if($user){
            $this->sendVerifyEmail($user->email,$user->roles_id);
            return view("auth.verifyEmail");
        }
        return redirect('/login');
    }

    private function sendVerifyEmail($email,$roles_id){

        $verify = DB::table('verify_emails')
                              ->where([
                                'email' => $email, 
                                'role_id' => $roles_id
                              ])
                              ->first();
        
        if($verify){
            $updated_at =$verify['updated_at'];
            $updated_at_time =Carbon::Parse($updated_at)->addMinutes(15);
        }

        if(!$verify){
            $token = Str::random(64);

            $verify= DB::table('verify_emails')->insert([
                'email' => $email,
                'role_id'=> $roles_id,
                'token' => $token,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_at' => Carbon::now()->toDateTimeString(),
              ]);

            Mail::send('email.verifyemail', ['token' => $token], function($message) use($email){
                $message->to($email);
                $message->subject('Verify email');
            });
        }else if($updated_at_time < Carbon::now()) {

           
            $token =$verify['token'];

            DB::table('verify_emails')->where('_id',$verify['_id'])
            ->update(['updated_at' => Carbon::now()->toDateTimeString() ]);
            Mail::send('email.verifyemail', ['token' => $token], function($message) use($email){
                $message->to($email);
                $message->subject('Verify email');
            });
        }

    }

     public function VerifyForm($token)
      {
          
          $updateUser = DB::table('verify_emails')
                              ->where([
                                'token' => $token
                              ])
                              ->first();

          if(!$updateUser){
              return back()->withInput()->with('error', 'Invalid token!');
          }

        $user = User::where('email', $updateUser['email'])->where('roles_id',$updateUser['role_id'])
        ->update(['isActive' => 1]);
        
        if($user){
            DB::table('verify_emails')->where(['email'=> $updateUser['email'] , 
                                                'role_id' => $updateUser['role_id']])
                ->delete();

            Notify::success("Successfully Verify your Email.", "Success",["closeButton" => true]);
            return redirect('/login');
        }
        else{
            Notify::error("Error in Verify Email. Please contact admin.", "Error",["closeButton" => true]);
        }

        return redirect()->back();

      }
 
}
