<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Helmesvs\Notify\Facades\Notify;

use  App\Models\System_settings;
use  App\Models\User;
use  App\Models\Event\Event;
use  App\Models\Event\Event_status;
use  App\Models\Event\Event_attendees;
use  App\Models\Document_upload as Upload;
use App\Models\Event\Audit\Audit_mark;
use  App\Models\User_roles as Roles;

class PenaziranController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }


    public function index(){
        return view('report.penaziran.index');
    }


    public function penaziranProcess($id){
        return view('report.penaziran.index-event')->with('id',$id);
    }

    public function listPenaziranProcess($id){
        // 1. Audit tu xde lagi dia akan show as new
        // 2. Kalau ada ada tunjuk event tu yg drpd draft if xsubmit lagi
        // 3. Kalau dah siap, tunjuk value sahaja

        $attandeescollection =collect(Event_attendees::where('event_id',$id)
         ->where('status','approve')
        ->get());
            
        $attandees = $attandeescollection->map(function($attandee) use ($attandeescollection){
            if($attandee->auditStatus != null) {
                $mark = $attandee->auditStatus->where(['auditor_id' =>Auth::id(),
                                                    'event_id' => $attandee->event_id,
                                                    'attendees_id' => $attandee->_id,
                                                   ])->first();
            }
            else $mark = null;
  
            $last_updated= 'None';
            $status = 'None';
            if($mark ){
                $last_updated = $mark['updated_at']->format('d/m/Y H:i:s A');
                $status = $mark['status'];
            }
            return [
                'id' => $attandee->_id,
                'name' => ucwords($attandee->participant->details->fullName),
                'nric' => ucwords($attandee->participant->nric),
                'role' => ucwords($attandee->participant->role->name),
                'phone' => $attandee->participant->details->phoneNumber,
                'email' => $attandee->participant->email, 
                'last_updated' => $last_updated,   
                 'status' => $status,

            ];
        }); 

        return DataTables::of($attandees)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        @if($status != "complete")
            <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="Menazir" href="/penazirans/create-penaziran/{{$id}}">
                <i class="fa fa-clipboard "></i>
            </a>
        @else
            <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/penazirans/penaziran-details/{{$id}}">
                <i class="fa fa-eye "></i>
            </a>
        @endif
        ')
       ->make(true);
    }

    public function create(Request $request,$id){

        $attandee = Event_attendees::find($id);
        $event_id = $attandee->event_id;
        $audit = collect(Audit_mark::where(['event_id'=>$event_id,
                                    'auditor_id' => Auth::id(),
                                    'attendees_id'=> $id])->first());
        //getting all document uploaded for this user  based on Audit_mark
        $documents = collect(Upload::where('refer_id',$audit->get('_id'))->get());

        return view('report.penaziran.create-penaziran')->with('attandee',$attandee)
                                                        ->with('audit', ($audit) ? $audit: collect())
                                                        ->with('document', ($documents) ? $documents: collect() );

    }

    public function listEventAnugerah(){

            $eventcollection = collect(Event::where('isAward',1)->
            whereHas('audit',function($q){
                return $q->where('user_id',Auth::id());
            })->
            whereHas('status', function($q){
                return $q->where('status','approve');
            })->get());
            

            $events = $eventcollection->map(function($event) use ($eventcollection){
                return [
                    'id' => $event->_id,
                    'name' => ucwords($event->name),
                    'category' => ($event->category) ? $event->category->name : 'No Category',
                    'type' => ($event->event_mode) ? ucwords($event->event_mode) : 'No Type',
                    'location'  => $event->location, 
                    'start_date' => $event->date_start->format('d/m/Y'),
                    'end_date' => $event->date_end->format('d/m/Y'),             
                ];
            }); 
    
            return DataTables::of($events)
            ->escapeColumns([])
            ->addIndexColumn()
            ->addColumn('action', '
            <a  class="btn btn-labeled btn-info" type="button" data-toggle="tooltip" data-placement="top" title="Penazirans" href="/penazirans/list-participants/{{$id}}">
            <i class="fa fa-clipboard "></i>
            </a>  
            ')
           ->make(true);
        
    }

    public function createAttendessMark(Request $request){

        if(!in_array($request->status,['complete','draft'])){
            Notify::error("Unrecognize Action Method.", "Failed",["closeButton" => true]);
            return back()->withErrors('Unrecognize Action Method.');
        }

        $audit_mark = $request->validate([
            'event_id' => 'required',
            'auditor_id' => 'required',
            'audit_item_id' => 'required',
            'attendees_id' => 'required',
            'status' => 'required',
            'mark' => 'required',
        ]);
        $audit_mark_id;
        if($request->has('audit_id')) {
            $audit_mark_id=$request->audit_id;
            Audit_mark::find($request->audit_id)->update($audit_mark);
            Notify::success("Update Penaziran Success.", "Penaziran",["closeButton" => true]);
        }
        else {
            $audit_mark_id= Audit_mark::create($audit_mark)['_id'];
            Notify::success("Create Penaziran Success.", "Penaziran",["closeButton" => true]);
        }
        //document upload refer Model
        if($request->has('penaziran_doc')){
            $audit_mark_files = $request->validate([
                'penaziran_doc' => 'required|array',
                'penaziran_doc.*' => 'required|file|max:5120',
            ]);
            $files = $request->file('penaziran_doc');
            $description = $request->penaziran_desc;
           
            foreach ($files as $index => $file) {
                $desc = ($description[$index]) ? $description[$index] : '-' ;
                Upload::upload_file('audit_mark',$audit_mark_id,'private','penaziran',$file,$desc);
            }      
        }
        if($request->status =='draft') return back();
        else return redirect('/penazirans/list-participants/'.$request->event_id);
    }

    public function viewPenaziranDetails($id){
        $attandee = Event_attendees::find($id);
        $event_id = $attandee->event_id;
        $audit = collect(Audit_mark::where(['event_id'=>$event_id,
                                    'auditor_id' => Auth::id(),
                                    'attendees_id'=> $id])->first());
        //getting all document uploaded for this user  based on Audit_mark
        $documents = collect(Upload::where('refer_id',$audit->get('_id'))->get());

        return view('report.penaziran.view-penaziran')->with('attandee',$attandee)
                                                        ->with('audit', ($audit) ? $audit: collect())
                                                        ->with('document', ($documents) ? $documents: collect() );

    }

    public function listPenaziranByPenazir($auditor_id){
        $auditcollection = collect(Audit_mark::where('auditor_id',$auditor_id)->where('status','complete')->get());

        $audits = $auditcollection->map(function($audit) use ($auditcollection){
            return [
                'id' => $audit->auditee->_id,
                'event_name'=> ucwords($audit->event->name),
                'attandance_name' => ucwords($audit->auditee->participant->details->fullName),
                'attandance_nric' => ucwords($audit->auditee->participant->nric),
                'attandance_role' => ucwords($audit->auditee->participant->role->name)
            ];
        });

        return DataTables::of($audits)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/mye-usahawan/penaziran-details/{{$id}}">
            <i class="fa fa-eye "></i>
        </a>
        ')
       ->make(true);

    }


    public function listPenaziranByDitazir($user_id){
        $attandeescollection = collect(Event_attendees::where('user_id',$user_id)->where('status','approve')->get());

        $attandees = $attandeescollection->map(function($attandee) use ($attandeescollection){
            if($attandee->auditStatus != NULL){
                $mark= $attandee->auditStatus->where('status','complete')->first();
                return [
                    'id' => $attandee->_id,
                    'event_name'=> ucwords($attandee->event->name),
                    'auditor_name' => ucwords($mark->auditor->details->fullName),
                    'auditor_nric' => ucwords($mark->auditor->nric),
                    'auditor_role' => ucwords($mark->auditor->role->name)
                ];
            } 
        })->filter();

        return DataTables::of($attandees)
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action', '
        <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/mye-usahawan/penaziran-details/{{$id}}">
            <i class="fa fa-eye "></i>
        </a>
        ')
       ->make(true);

    }

}
