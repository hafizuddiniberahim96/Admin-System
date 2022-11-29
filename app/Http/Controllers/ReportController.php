<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Helmesvs\Notify\Facades\Notify;


use  App\Models\Event\Event;
use  App\Models\Event\Event_summary;
use  App\Models\Event\Event_attendees;

use  App\Models\Event\Audit\Auditor_event;
use  App\Models\Event\Audit\Audit_mark;



use  App\Models\System_settings;
use  App\Models\User_roles as Roles;
use  App\Models\User;

use  App\Models\Document_upload as Upload;

use Carbon\Carbon;


class ReportController extends Controller
{
    //
    public function index(){
        if(Gate::check('isAdmin'))
            return view('event.finish-events');
        else
            return view('report.index');
    }

    public function uploadFile(Request $request){

        try{
            $files = $request->file('report_doc');
            $description = $request->report_desc;

            foreach ($files as $index => $file) {
                $desc = ($description[$index]) ? $description[$index] : '-' ;
                Upload::upload_file('report_user',Auth::id(),'private','report',$file,$desc);
            }
            Notify::success("Upload Reports Success.", "Report",["closeButton" => true]);
        }
        catch (Throwable $e) {
            Notify::error("Upload Report Failed.", "Report",["closeButton" => true]);
        }

        return redirect('/reports');
    }

    public function reviewReport($id){
        $event = Event::getEvent($id);
        $start_date = Carbon::createFromFormat('d/m/Y', $event['date_start']);
        $end_date = Carbon::createFromFormat('d/m/Y', $event['date_end']);


        $event_eloquent = Event::find($id);
        $records = collect([
            "event_duration" => $end_date->diffInDays($start_date) + 1,
            "total_participant" => $event_eloquent->attendees->count(),

        ]);
        return view('report.review-report')
        ->with('event',$event)
        ->with('budget',Event_summary::where('event_id',$id)->first())
        ->with('programs',System_settings::where('tableName','Program Category')->get())
        ->with('participants',Roles::whereNotIn('name',['admin'])->get())
        ->with('penazirs',User::where(['isActive' => 1, 'isApproved' => 1, 'registerComplete' => 1])
        ->whereHas('role', function ($q){
            $q->whereIn('name',['teacher','instructor','secretariat','admin']);
        })->get())
        ->with('expenses',System_settings::where('tableName','Budget Expenses Type')->get())
        ->with('reasons',System_settings::where('tableName','Payment Reason')->get())
        ->with('records', $records);
    }

    public function listAttendeesMark($event_id){
        $audit_marks = Audit_mark::where('event_id',$event_id)->get();

        $total_per_auditor = $audit_marks->map(function($mark) use ($event_id){
            $total= 0;
            $mark_array = $mark->mark;
            foreach($mark_array as $value){ $total += $value;}
            return [
                'attendees_id' => $mark->attendees_id,
                'name' => $mark->auditee->participant->details->fullName,
                'nric' => $mark->auditee->participant->nric,
                'role' => $mark->auditee->participant->role->name,
                'email' => $mark->auditee->participant->email,
                'total' => ($total/(100* count($mark_array))),
            ];
        });

        $total_per_attendees = collect($total_per_auditor)->groupBy('attendees_id');
        $total = $total_per_attendees->mapWithKeys(function ($group, $key) {
            return [
                $key =>
                    [
                        'attendees_id' => $key, // $key is what we grouped by, it'll be constant by each  group of rows
                        'name' => $group->first()['name'],
                        'nric' => $group->first()['nric'],
                        'role' => $group->first()['role'],
                        'email' => $group->first()['email'],
                        'mark' => ($group->sum('total') /$group->count()) * 100  ,
                      
                    ]
            ];
        })->values();

        return DataTables::of($total)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', 
        '<a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="View Details" href="/reports/view-marks-details/{{$attendees_id}}">
            <i class="fa fa-eye"></i>
        </a>  
        ')
        ->make(true);


    }

    public function listAttendance($event_id){
        $participants = collect(Event_attendees::where('event_id',$event_id)->where('status','approve')->get());
        $event = Event::find($event_id);
        $duration = Carbon::parse($event->date_end)->diffInDays(Carbon::parse($event->date_start)) + 1;
        $attendance = $participants->map(function($attendee) use($event_id,$duration) {
            $present= $attendee->attendance->where('event_id',$event_id)->count();

            return [
                
                'name' => $attendee->participant->details->fullName,
                'nric' => $attendee->participant->nric,
                'role' => $attendee->participant->role->name,
                'email' => $attendee->participant->email,
                'phoneNumber' => $attendee->participant->details->phoneNumber,
                'present' => $present,
                'absent' => ($duration - $present), 
            ];
        });
        return DataTables::of($attendance)
        ->escapeColumns([])
        ->addIndexColumn()
        ->make(true);
    }

    public function viewPenaziranDetails($id){
        $attandee_mark = Audit_mark::where('attendees_id',$id)->get();
        return view('report.penaziran-details')->with('attandees',$attandee_mark);
    }

    

}
