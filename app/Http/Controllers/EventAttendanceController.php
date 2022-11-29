<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event\Event_attendance as Attendance;
use App\Models\Event\Event_QrLink;
use  App\Models\Event\Event_attendees;
use  App\Models\User_roles as Roles;
use App\Models\User;


use Illuminate\Support\Facades\Auth;
use Helmesvs\Notify\Facades\Notify;
use Carbon\Carbon;


class EventAttendanceController extends Controller
{
    //
    public function attendance($event_id,$token){
        $qrcode= Event_QrLink::where(['event_id' => $event_id,
                                      'token' => $token,
        ])
        ->where('expires_in','>',Carbon::now())
        ->first();
        if(empty($qrcode) && Auth::check()){
            Notify::error("Event QR Code is Expired !", "Attendance",["closeButton" => true]);
            return redirect('home');
        }
        else if (empty($qrcode)){
            return view('event.attendance.checked-in')->with('message', "Event QRCode/Link is Expired !");
        }

        if(!Auth::check()){
            $roles = Roles::select('_id as id', 'name')->where('name', '<>', 'admin')->get();
            return view('event.attendance.check-in')->with('event_id',$event_id)->with('token',$token)->with('roles',$roles);
        }else{
             $participated=Event_attendees::where(['user_id'=>Auth::id() ,'event_id'=>$event_id,'status' => 'approve'])->first();
            if(empty($participated)){
                Notify::error("User Not Participate In Event !", "Attendance",["closeButton" => true]);
                return redirect('home');
            }

            $attended =Attendance::where(['event_id' => $event_id,
            'user_id' => Auth::id(),
            'attend_on' => Carbon::now()->timezone('Asia/Singapore')->toDateString()
            ])->first();

            if(empty($attended)){
                $attendance = Attendance::create(['event_id' => $event_id,
                                                'user_id' => Auth::id(),
                                                'attend_on' =>  Carbon::now()->timezone('Asia/Singapore')->toDateString()
                                                ]);
             
            } 
                Notify::success("Your Attended Is Recorded, Thank You !", "Attendance",["closeButton" => true]);
                return redirect('home')->with('message', "Your Attended Is Recorded, Thank You!");
        }
     

       

    }

    public function checkInWithoutLogin(Request $request){
        $user = User::where(['nric' => $request->nric, 'roles_id' => $request->roles])->first();
        if (empty($user)) {
            Notify::error("User Did not Participated in Event !", "Attendance",["closeButton" => true]);
            return redirect(url()->previous());
        }
        
        $participated=Event_attendees::where(['user_id'=>$user['_id'] ,'event_id'=>$request->event_id,'status'=>'approve'])->first();
         if(empty($participated)){
                Notify::error("User Not Participate In Event !", "Attendance",["closeButton" => true]);
                 return redirect(url()->previous());
            }
        $attended =Attendance::where(['event_id' => $request->event_id,
            'user_id' => $user['_id'],
            'attend_on' => Carbon::now()->timezone('Asia/Singapore')->toDateString()
        ])->first();
        if(empty($attended)){
            $attendance = Attendance::create(['event_id' => $request->event_id,
                                            'user_id' => $user['_id'],
                                            'attend_on' =>  Carbon::now()->timezone('Asia/Singapore')->toDateString()
                                            ]);
        }
        return view('event.attendance.checked-in')->with('message', "Your Attended Is Recorded For Today !");

    }
}
