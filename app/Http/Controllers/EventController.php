<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;

use Helmesvs\Notify\Facades\Notify;

use  App\Models\System_settings;
use  App\Models\User;
use  App\Models\Event\Event;
use  App\Models\Event\Event_status;
use  App\Models\Event\Event_attendees;
use  App\Models\Event\Event_summary;
use  App\Models\Event\Event_participant;

use App\Models\Event\Event_QrLink;
use App\Models\Event\Event_attendance as Attendance;
use App\Models\Event\Audit\Auditor_event as Penazir;
use App\Models\Event\Audit\Audit_mark;


use  App\Models\User_roles as Roles;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PDF;
// use QRCode;

class EventController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(){
        if(Auth::user()->role->name == 'admin')
            return view('event.index');

        $string_todayDate = Carbon::now()->toDateString();
        $todayDate = Carbon::parse($string_todayDate);

        $statuscollection = collect(Event_status::where('status','approve')->whereHas('event', function ($q) use ($todayDate){
            return $q->where('register_before','>=', $todayDate);
        })->orderBy('created_at','DESC')->get());

        $roles_user = Auth::user()->roles_id;
        $events = $statuscollection->map(function($status) use ($roles_user){
               $total_attendees = Event_attendees::where(['event_id' => $status->event_id,
                                         'status' => 'approve'])->count();
               $participants_roles = collect(Event_participant::where('event_id',$status->event_id)->get())->map(function($role_participant){ return $role_participant->roles_id;})->toArray();
               if(in_array($roles_user,$participants_roles))
                    return [
                        'id' => $status->event_id,
                        'name' => ucwords($status->event->name),
                        'create_by' => ucwords($status->pendingBy->details->fullName),
                        'start_date' => $status->event->date_start->format('d/m/Y'),
                        'end_date' => $status->event->date_end->format('d/m/Y'),                
                        'category' => ($status->event->category) ? $status->event->category->name : 'No Category',
                        'type' => ($status->event->event_mode) ? ucwords($status->event->event_mode) : 'No Type',
                        'location'  => $status->event->location,              
                        'banner'  => $status->event->bannerImg,              
                        'logo'  => $status->event->logo,              
                        'fee'  => $status->event->fee,    
                        'seats'  => ($status->event->seats == -1) ? "Unlimited" : (int) $status->event->seats - $total_attendees,              
                    ];
            
        })->filter();
            return view('event.all-events')
            ->with('events',$events);

    }

    public function create(){
      
        return view('event.create')
        ->with('event',collect([]))
        ->with('programs',System_settings::where('tableName','Program Category')->get())
        ->with('participants',Roles::whereNotIn('name',['admin'])->get())
        ->with('penazirs',User::where(['isActive' => 1, 'isApproved' => 1, 'registerComplete' => 1])
        ->whereHas('role', function ($q){
            $q->whereIn('name',['teacher','instructor','secretariat','admin']);
        })
        ->get())
        ->with('expenses',System_settings::where('tableName','Budget Expenses Type')->get())
        ->with('reasons',System_settings::where('tableName','Payment Reason')->get());

    }

    public function updateEvent($event_id){
        $event = Event::getEvent($event_id);
  
        return view('event.create')
        ->with('event',collect($event))
        ->with('programs',System_settings::where('tableName','Program Category')->get())
        ->with('participants',Roles::whereNotIn('name',['admin'])->get())
        ->with('penazirs',User::where(['isActive' => 1, 'isApproved' => 1, 'registerComplete' => 1])
        ->whereHas('role', function ($q){
            $q->whereIn('name',['teacher','instructor','secretariat','admin']);
        })->get())
        ->with('expenses',System_settings::where('tableName','Budget Expenses Type')->get())
        ->with('reasons',System_settings::where('tableName','Payment Reason')->get());
    }

    public function viewEvent($event_id){
        $event = Event::getEvent($event_id);

        return view('event.detail')
        ->with('event',collect($event))
        ->with('programs',System_settings::where('tableName','Program Category')->get())
        ->with('participants',Roles::whereNotIn('name',['admin'])->get())
        ->with('penazirs',User::where(['isActive' => 1, 'isApproved' => 1, 'registerComplete' => 1])
        ->whereHas('role', function ($q){
            $q->whereIn('name',['teacher','instructor','secretariat','admin']);
        })->get())
        ->with('expenses',System_settings::where('tableName','Budget Expenses Type')->get())
        ->with('reasons',System_settings::where('tableName','Payment Reason')->get());
    }

    public function createEvent(Request $request){
     

        if($request->status) $results = Event::createEvent($request);
        Notify::success("Event Successfully Created!", "Create Event",["closeButton" => true]);
        return redirect('/events');
    }

    public function draftEvent(){
        $statuscollection = collect(Event_status::where('status','draft')->orderBy('created_at','DESC')->get());
        $events = $statuscollection->map(function($status) use ($statuscollection){

            return [
                'id' => $status->event->_id,
                'name' => ucwords($status->event->name),
                'create_by' => $status->pendingBy->details->fullName,
                'category' => ($status->event->category) ? $status->event->category->name : 'No Category',
                'type' => ($status->event->event_mode) ? $status->event->event_mode : 'No Type',               
            ];
            
        }); 
        

        return DataTables::of($events)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action','
        <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="Update" href="events/update-events/{{$id}}">
            <i class="fa fa-edit"></i>
        </a>
        <a  class="btn btn-labeled btn-danger" type="button"  data-placement="top" title="Remove" href="events/delete-event/{{$id}}">
            <i class="fa fa-trash"></i>
        </a>   
        ')
        ->make(true);
       
    }
    
    public function pendingEvent(){
        $statuscollection = collect(Event_status::where('status','pending')->orderBy('created_at','DESC')->get());
        $events = $statuscollection->map(function($status) use ($statuscollection){

            return [
                'id' => $status->event_id,
                'name' => ucwords($status->event->name),
                'create_by' => ucwords($status->pendingBy->details->fullName),
                'category' => ($status->event->category) ? $status->event->category->name : 'No Category',
                'type' => ($status->event->event_mode) ? ucwords($status->event->event_mode) : 'No Type',
                'start_date' => $status->event->date_start->format('d/m/Y'),
                'end_date' => $status->event->date_end->format('d/m/Y'),
                'fee' => ($status->event->fee) > 0 ? 'RM '.number_format($status->event->fee ,2): 'Free',    
                'anugerah' => ($status->event->isAward) > 0 ? 'Yes' : 'No',         
                'location'  => $status->event->location,              
            ];
            
        }); 
        return DataTables::of($events)
        ->escapeColumns([])
        ->addIndexColumn()
        ->editColumn('name',
        '<a href="/events/view-events/{{$id}}">{{$name}}</a>  '
        )
        ->addColumn('action', '
        <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="Approve" href="/events/event-action/approve/{{$id}}">
            <i class="fa fa-check"></i>
        </a>  
        <a  class="btn btn-labeled btn-warning" type="button"  data-placement="top" title="Reject" href="/events/event-action/reject/{{$id}}">
            <i class="fa fa-close"></i>
        </a>  
        ')->make(true);
    }

    public function approveEvent(){
        $statuscollection = collect(Event_status::where('status','approve')->orderBy('created_at','DESC')->get());
        $events = $statuscollection->map(function($status) use ($statuscollection){

            return [
                'id' => $status->event_id,
                'name' => ucwords($status->event->name),
                'create_by' => ucwords($status->pendingBy->details->fullName),
                'approve_by' => ucwords($status->approveBy->details->fullName),
                'start_date' => $status->event->date_start->format('d/m/Y'),
                'end_date' => $status->event->date_end->format('d/m/Y'),                
                'category' => ($status->event->category) ? $status->event->category->name : 'No Category',
                'type' => ($status->event->event_mode) ? ucwords($status->event->event_mode) : 'No Type',
                'location'  => $status->event->location,              
            ];
            
        }); 
        return DataTables::of($events)
        ->escapeColumns([])
        ->addIndexColumn()
        ->editColumn('name',
        '<a href="/events/view-events/{{$id}}">{{$name}}</a>  '
        )
        ->addColumn('action', '
        <a  class="btn btn-labeled btn-warning" type="button" data-toggle="tooltip" data-placement="top" title="Cancel"  href="/events/event-action/cancel/{{$id}}">
            <i class="fa fa-ban"></i>
        </a>    
        ')
       ->make(true);
    }

    public function rejectEvent(){
        $statuscollection = collect(Event_status::whereIn('status',['reject','cancel'])->orderBy('created_at','DESC')->get());
        $events = $statuscollection->map(function($status) use ($statuscollection){
            return [
                'id' => $status->event_id,
                'name' => ucwords($status->event->name),
                'fee' => ($status->event->fee) > 0 ? 'RM '.number_format($status->event->fee,2) : 'Free',    
                'create_by' => ucwords($status->pendingBy->details->fullName),
                'reject_by' => ($status->rejectBy) ? ucwords($status->rejectBy->details->fullName) : ucwords($status->cancelBy->details->fullName),
                'category' => ($status->event->category) ? $status->event->category->name : 'No Category',
                'type' => ($status->event->event_mode) ? ucwords($status->event->event_mode) : 'No Type',
                'status' => ucwords($status->status),
                'location'  => $status->event->location,              
            ];
            
        }); 
        return DataTables::of($events)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        @if($status == "Reject")
        <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="Update" href="events/update-events/{{$id}}">
            <i class="fa fa-edit"></i>
        </a> 
        @else
        <a  class="btn btn-labeled btn-danger" type="button"  data-placement="top" title="Remove" href="events/delete-event/{{$id}}">
            <i class="fa fa-trash"></i>
        </a>
        @endif
        ')
       ->make(true);
    }

    public function eventAction($action,$event_id){
        if(!in_array($action,['approve','reject','finish','cancel'])){
            Notify::error("Unrecognize Action Method.", "Failed",["closeButton" => true]);
            return back()->withErrors('Unrecognize Action Method.');
        }
      
        Event_status::where('event_id',$event_id)->update([$action.'_by' => Auth::id(), 'status'=> $action]);
        Notify::success("Event Successfully Updated!", ucwords($action),["closeButton" => true]);
        return redirect('/events');

    }

    public function deleteEvent($event_id){
        $status = Event::deleteEvent($event_id);
        if($status){
            Notify::success("Event Successfully Deleted!", "Delete",["closeButton" => true]);
            return back();
        }else{
            Notify::error("Event not Found.", "Failed",["closeButton" => true]);
            return back()->withErrors('Unrecognize Action Method.');
        }
        
    }
    /*********************FINISHED EVENT****************************** */
    public function listFinishedEvent(){
        $string_todayDate = Carbon::now()->toDateString();
        $todayDate = Carbon::parse($string_todayDate);

        $statuscollection = collect(Event_status::where('status','finish')
        ->get());


        $events = $statuscollection->map(function($status) use ($statuscollection){

            return [
                'id' => $status->event_id,
                'name' => ucwords($status->event->name),
                'anugerah' => ($status->event->isAward) ? 'Yes' : 'No',
                'create_by' => ucwords($status->pendingBy->details->fullName),
                'approve_by' => ucwords($status->approveBy->details->fullName),
                'start_date' => $status->event->date_start->format('d/m/Y'),
                'end_date' => $status->event->date_end->format('d/m/Y'),                
                'category' => ($status->event->category) ? $status->event->category->name : 'No Category',
                'type' => ($status->event->event_mode) ? ucwords($status->event->event_mode) : 'No Type',
                'location'  => $status->event->location,              
            ];
            
        }); 

        return DataTables::of($events)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', 
        '<a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="Create Report" href="/reports/review-report/{{$id}}">
            <i class="fa fa-clipboard"></i>
        </a>  
        ')->make(true);
    }

    /*********************CLOSED EVENT****************************** */
    public function closedEvent(){

        return view('event.closed-events');
    }

    public function listClosedEvent(){
        $string_todayDate = Carbon::now()->toDateString();
        $todayDate = Carbon::parse($string_todayDate);

        $statuscollection = collect(Event_status::where('status','approve')
        ->whereHas('event', function($q) use ($todayDate){
            return $q->where('date_end', '<', $todayDate);
        })->get());


        $events = $statuscollection->map(function($status) use ($statuscollection){

            return [
                'id' => $status->event_id,
                'name' => ucwords($status->event->name),
                'anugerah' => ($status->event->isAward) ? 'Yes' : 'No',
                'create_by' => ucwords($status->pendingBy->details->fullName),
                'approve_by' => ucwords($status->approveBy->details->fullName),
                'start_date' => $status->event->date_start->format('d/m/Y'),
                'end_date' => $status->event->date_end->format('d/m/Y'),                
                'category' => ($status->event->category) ? $status->event->category->name : 'No Category',
                'type' => ($status->event->event_mode) ? ucwords($status->event->event_mode) : 'No Type',
                'location'  => $status->event->location,              
            ];
            
        }); 

        return DataTables::of($events)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', 
        '<a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="Create Report" href="/events/create-report/{{$id}}">
            <i class="fa fa-clipboard"></i>
        </a>  
        ')->make(true);
    }

    public function createReport($id){
        $event = Event::getEvent($id);
        $status = $this->PenaziranIsComplete($id);
        
        return view('event.create-report')
        ->with('event',$event)
        ->with('programs',System_settings::where('tableName','Program Category')->get())
        ->with('participants',Roles::whereNotIn('name',['admin'])->get())
        ->with('penazirs',User::where(['isActive' => 1, 'isApproved' => 1, 'registerComplete' => 1])
        ->whereHas('role', function ($q){
            $q->whereIn('name',['teacher','instructor','secretariat','admin']);
        })->get())
        ->with('expenses',System_settings::where('tableName','Budget Expenses Type')->get())
        ->with('reasons',System_settings::where('tableName','Payment Reason')->get())
        ->with('status_penaziran',$status);
    }

    private function PenaziranIsComplete($id){
        $penazirs = Penazir::where('event_id',$id)->get();
        $attendees_count = Event_attendees::where('event_id',$id)->where('status','approve')->count();
        if ($attendees_count == 0) return true;
        foreach( $penazirs as $penazir){
                $completed_task = Audit_mark::where(['event_id' => $penazir->event_id,
                'auditor_id' => $penazir->user->_id,
                'status' => 'complete'
            ])->count();
            if(($attendees_count - $completed_task) > 0 ) return false;
        }
        return true;

    }

    public function listPenazirProgress($id){

        $penazircollection = collect(Penazir::where('event_id',$id)->get());

        $attendees_count = Event_attendees::where('event_id',$id)->where('status','approve')->count();
     
        $penazirs = $penazircollection->map(function($penazir) use ($penazircollection, $attendees_count){
            $completed_task = Audit_mark::where(['event_id' => $penazir->event_id,
                                                'auditor_id' => $penazir->user->_id,
                                                'status' => 'complete'
                                            ])->count();
            return [
                'id' => $penazir->user->_id,
                'name' => ucwords($penazir->user->details->fullName),
                'nric' => ucwords($penazir->user->nric),
                'role' => ucwords($penazir->user->role->name),
                'phone' => $penazir->user->details->phoneNumber,
                'email' => $penazir->user->email, 
                'status' => ($attendees_count == $completed_task ) ? 'completed' : 'incomplete',
                'incomplete_count' => $attendees_count - $completed_task,

            ];
        });       
        return DataTables::of($penazirs)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('badge','
        <h5>
            @if($status == "completed")
                <span class = "badge  badge-success">Completed</h3>
            @else
                <span class = "badge  badge-danger">Incomplete</h3>
                <label class="text-danger">{{$incomplete_count}} remaining</label>
            @endif
        </h5>
        ')
        ->addColumn('action', '
        @if($status == "incomplete")
            <a  class="btn btn-labeled btn-success text-white" type="button"  data-placement="top" data-title="Assign" data-toggle="modal" data-target="#assign-penazir"  data-value="{{$name}}" data-href="/events/change-penazir/{{$id}}">
                <i class="fa fa-user"></i>
            </a> 
        @else
            <span class = "badge  badge-info">Not Available</h3>
        @endif 
        ')
       ->make(true);

    }
    public function changePenazir(Request $request, $auditor_id){
        Penazir::where(['event_id'=> $request->event_id,
                                    'user_id' => $auditor_id])
                            ->update(['user_id' => $request->change_penazir_id]);
        
        $results = Audit_mark::where(['event_id'=> $request->event_id,
                                        'auditor_id' => $auditor_id])
                                        ->update(['user_id' => $request->change_penazir_id]);

        
   
            Notify::success("Penazir Event Successfully Change!", "Event",["closeButton" => true]);      
 
        return back();
    }

    public function myEvents(){
        $eventcollection= collect(Event_attendees::where(['user_id'=> Auth::id(),'status'=>'approve'])->orderBy('created_at','DESC')->get());
        $events = $eventcollection->map(function($attendees) use ($eventcollection){
            return [
                'id' => $attendees->event_id,
                'name' => ucwords($attendees->event->name),
                'start_date' => $attendees->event->date_start->format('d/m/Y '),
                'end_date' => $attendees->event->date_end->format('d/m/Y '),                
                'category' => ($attendees->event->category) ? $attendees->event->category->name : 'No Category',
                'type' => ($attendees->event->event_mode) ? ucwords($attendees->event->event_mode) : 'No Type',
                'location'  => $attendees->event->location,              
                'banner'  => $attendees->event->bannerImg,              
                'logo'  => $attendees->event->logo,   
                'fee'  => $attendees->event->fee,              
                'seats'  => ($attendees->event->seats == -1) ? "Unlimited" : $attendees->event->seats,              
            ];
        }); 
        return view('event.my-events')
        ->with('events', $events);
    }

    public function registrations(){
        return view('event.registrations');
    }

    public function registerEvent($event_id,$user_id){
        
       $participated=Event_attendees::where(['user_id'=>$user_id,'event_id'=>$event_id])->first();
       if($participated) Notify::error("User already on List Registered", "Registered",["closeButton" => true]);
       else {
            $registered= Event_attendees::create(['event_id' => $event_id, "user_id"=>$user_id, 'isPresent' => 0, 'status'=> 'pending']);
            if($registered) Notify::success("Event Successfully Registered!", "Register",["closeButton" => true]);
                else  Notify::error("Failed to Registered! Please Contact Admin.", "Register",["closeButton" => true]);
       }
       
        return back();

    }

   
    /*********************Registering Event Approval **********************/

    public function approvalAttendees($action){
        if(!in_array($action,['pending','approve','reject'])){
            Notify::error("Unrecognize Action Method.", "Failed",["closeButton" => true]);
            return back()->withErrors('Unrecognize Action Method.');
        }

        $attendeescollection = collect(Event_attendees::where(['status'=>$action])->get());
        $pending = $attendeescollection->map(function($attendees) use ($attendeescollection){

            return [
                'id' => $attendees->_id,
                'event'=>ucwords($attendees->event->name),
                'status'=> $attendees->status,
                'name' => ucwords($attendees->participant->details->fullName),
                'nric' => $attendees->participant->nric,
                'role' => ucwords($attendees->participant->role->name),
                'phone' => $attendees->participant->details->phoneNumber,
                'email' => $attendees->participant->email,   
            ];
            
        });

        return DataTables::of($pending)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        @if($status == "pending")
        <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="Approve" href="/events/register-action/approve/{{$id}}">
            <i class="fa fa-check"></i>
        </a>  
        <a  class="btn btn-labeled btn-warning" type="button"  data-placement="top" title="Reject" href="/events/register-action/reject/{{$id}}">
            <i class="fa fa-close"></i>
        </a>
        @endif
        ')->make(true);

    }

    public function registerAction($action,$attendees_id){
        if(!in_array($action,['approve','reject'])){
            Notify::error("Unrecognize Action Method.", "Failed",["closeButton" => true]);
            return back()->withErrors('Unrecognize Action Method.');
        }

        if($action == 'approve'){
            $event_id = Event_attendees::find($attendees_id)->event_id;
            $seats = Event::find($event_id)->seats;
            $taken = Event_attendees::where(['event_id' => $event_id,
                                             'status' => 'approve'])->count();
            $left = $seats - $taken;
            if($left <= 0){
                Notify::error("No Seats Left for this Event.", "Failed",["closeButton" => true]);
                return back()->withErrors('No Seats Left.');
            } 
        }

        Event_attendees::find($attendees_id)->update(['status'=> $action]);
        Notify::success("Attendees Successfully Updated!", ucwords($action),["closeButton" => true]);
        return back();
    }

    /************************Event Attendance ************************* */

    public function ongoingEvent(){
        return view('event.ongoing-events');
    }

  

    public function listOngoingEvent(){
        $string_todayDate = Carbon::now()->toDateString();
        $todayDate = Carbon::parse($string_todayDate);
      
        $statuscollection = collect(Event_status::where('status','approve')
        ->whereHas('event', function($q) use ($todayDate){
            return $q->where('date_end', '>=', $todayDate)
            ->orWhere('date_start', '>=',$todayDate)->get();
        })->get());
        $events = $statuscollection->map(function($status) use ($statuscollection){

            return [
                'id' => $status->event_id,
                'name' => ucwords($status->event->name),
                'create_by' => ucwords($status->pendingBy->details->fullName),
                'approve_by' => ucwords($status->approveBy->details->fullName),
                'start_date' => $status->event->date_start->format('d/m/Y'),
                'end_date' => $status->event->date_end->format('d/m/Y'),                
                'category' => ($status->event->category) ? $status->event->category->name : 'No Category',
                'type' => ($status->event->event_mode) ? ucwords($status->event->event_mode) : 'No Type',
                'location'  => $status->event->location,              
            ];
            
        }); 
        return DataTables::of($events)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
    
            <a  class="btn btn-labeled btn-info " type="button" data-toggle="tooltip" data-placement="top" title="Create Attendance"  href="/events/attendance-links/{{$id}}">
                <i class="fa fa-qrcode"></i>
            </a> 
            </br>
            <a  class="btn btn-labeled btn-info mt-1" type="button" data-toggle="tooltip" data-placement="top" title="List All Attendance"  href="/events/attendance-all-participants/{{$id}}">
                <i class="fa fa-list-ol"></i>
            </a>   
 
        ')
       ->make(true);
    }

   

    public function attendanceLink($event_id){

        $event = Event::where('_id',$event_id)->firstOrFail();
      
        return view('event.attendance.index')->with('event',$event);
    }

    public function listAttendanceLink($event_id){
        $todayDate = Carbon::now();
        $linkcollection= Event_QrLink::where('event_id',$event_id)->get();


        $links = $linkcollection->map(function($link) use ($linkcollection){
         
            return [
                'id' => $link->_id,
                'link' => url('events/attendance/').'/'.$link->event_id.'/'.$link->token,
                'status' => ($link->expires_in > Carbon::now()->timezone('Asia/Singapore')) ? 'Active' : 'Expired', 
                'created_at' =>$link->created_at->format('d/m/Y H:i:s A'), 
                'date' =>$link->created_at->format('d-m-Y'), 
            ];
            
        }); 

        return DataTables::of($links)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="View attendance"  href="/events/attendance-participants/'.$event_id.'/{{$date}}">
            <i class="fa fa-list-ol"></i>
        </a>    
        ')
        ->addColumn('qrcode', '
        <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="View QRCode"  href="/events/attendance-link/{{$id}}">
            <i class="fa fa-qrcode"></i>
        </a>    
        ')
       ->make(true);
    }

    public function createAttendance($event_id){

        $event = Event::where('_id',$event_id)->firstOrFail();
        
        if(empty($event)){
            Notify::error("Event Not Found ! Please Contact Admin.", "Attendance",["closeButton" => true]);
            return back();
        }else{
            
            $end_date =  Carbon::parse($event['date_end'])->format('d/m/Y');
            $today_date= Carbon::now()->timezone('Asia/Singapore')->format('d/m/Y');
           
            
            if($today_date > $end_date){
                Notify::error("Event is Already Expired !", "Attendance",["closeButton" => true]);
                return back();
            }
            
            $qr_link = Event_QrLink::where('event_id',$event_id)->where('expires_in','>',Carbon::now())->first();
            if(empty($qr_link)){
                $token = Str::random(64);
                $expires_in = Carbon::now()->addHours(12);
                $qr_link =Event_QrLink::create([
                    'event_id' => $event_id,
                    'token' => $token,
                    'expires_in' => $expires_in->toDateTimeString()                   
                ]);
            }
            $qr_link['event_name'] = $event->name;

            return view('event.attendance.create')
            ->with('link', $qr_link);
        }
       
    }

    public function viewAttendanceParticipants($event_id,$date){
        return view('event.attendance.participants-list')->with('date',$date)->with('event_id',$event_id);

    }

    public function listAttendanceParticipants($event_id,$date){
        $date = Carbon::createFromFormat('d-m-Y', $date)->timezone('Asia/Singapore')->format('Y-m-d');
        $participants_attend= collect(Attendance::where(['event_id' => $event_id, 'attend_on' => $date ])->get());
        $attendees = $participants_attend->map(function($attendee) use ($participants_attend){
            return [
                'id' => $attendee->_id,
                'role' => ucwords($attendee->participant->role->name),
                'name' => ucwords($attendee->participant->details->fullName),
                'nric' => $attendee->participant->nric,
                'phone' => $attendee->participant->details->phoneNumber,
                'email' => $attendee->participant->email,
                'attend_on' => $attendee->created_at->format('d/m/y H:i:s A'),
            ];
            
        }); 

        return DataTables::of($attendees)
        ->escapeColumns([])
        ->addIndexColumn()
       ->make(true);

    }

    
    public function viewAttendanceAllParticipants($event_id){
        return view('event.attendance.participants-list-all')->with('event_id',$event_id);

    }

    public function listAttendanceAllParticipants($event_id){
        $participants_attend= collect(Attendance::where(['event_id' => $event_id])->get());
        $attendees = $participants_attend->map(function($attendee) use ($participants_attend){
            return [
                'id' => $attendee->_id,
                'role' => ucwords($attendee->participant->role->name),
                'name' => ucwords($attendee->participant->details->fullName),
                'nric' => $attendee->participant->nric,
                'phone' => $attendee->participant->details->phoneNumber,
                'email' => $attendee->participant->email,
                'attend_on' => $attendee->created_at->format('d/m/y H:i:s A'),
            ];
            
        }); 

        return DataTables::of($attendees)
        ->escapeColumns([])
        ->addIndexColumn()
       ->make(true);

    }

    public function viewAttendanceLink($qrink_id){
        $qrlink = Event_QrLink::find($qrink_id);
        $qrlink['event_name'] = $qrlink->event->name;
        return view('event.attendance.create')
        ->with('link', $qrlink);

    }

    public function printQRCodeAttendance($event_id){
        $event = Event::where('_id',$event_id)->firstOrFail();

        $qrlink = Event_QrLink::where('event_id',$event_id)->where('expires_in','>',Carbon::now())->first();

        $invoice = PDF::loadView('event.attendance.print-qrcode-attendance',compact('event','qrlink'));
        return $invoice->stream();
    }

    #************************FINISHED EVENT****************************#
    public function finishedEvent(Request $request){

        try {
            $validated = $request->validate([
                'expenses_used.*' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'overBudget.*' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ]);

            Event_status::where('event_id',$request->event_id)
             ->update(['status' => 'finish',
                   'finish_by' => Auth::id()
                ]);
            Event_summary::create($request->all());
            Notify::success("Event Finished Successfully!", "Close Event",["closeButton" => true]);

            return redirect('/reports');

        } catch (Throwable $e) {
            Notify::error("Failed To Update Event!", "Close Event",["closeButton" => true]);
            return redirect('/events/closed-events');

        }
        
    }

    public function listAllParticipants($event_id){
        $participants_attendees= collect(Event_attendees::where(['event_id' => $event_id])->get());
        $attendees = $participants_attendees->map(function($attendee) use ($participants_attendees){
            return [
                'id' => $attendee->_id,
                'role' => ucwords($attendee->participant->role->name),
                'name' => ucwords($attendee->participant->details->fullName),
                'nric' => $attendee->participant->nric,
                'phone' => $attendee->participant->details->phoneNumber,
                'email' => $attendee->participant->email,
                'status' => ucwords($attendee->status),
            ];
            
        }); 

        return DataTables::of($attendees)
        ->escapeColumns([])
        ->addIndexColumn()
        ->editColumn('status',
        '
        @if($status == "Reject")
            <span  class = "badge  badge-danger">
            {{$status}}
            </span>
        @else
            <span  class = "badge  badge-success">
            {{$status}}
            </span>
        @endif
        
        '
        )
       ->make(true);

    }

}
