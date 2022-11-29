<?php

namespace App\Models\Event;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\System_settings;
use App\Models\Event\Event_participant;
use App\Models\Event\Event_status;
use App\Models\Event\Event_expense as Expenses;
use App\Models\Event\Event_summary as Summary;
use App\Models\Event\Event_attendees as Attendees;

use App\Models\Event\Audit\Auditor_event;
use App\Models\Event\Audit\Audit_item;
use App\Models\Event\Audit\Audit_mark;


use Illuminate\Http\Request;
use  App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class Event extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'events';

    protected $fillable = [
        'system_settings_id',  #Program Category
        'name',
        'logo',
        'event_mode',
        'location',
        'bannerImg',
        'seats',
        'fee',
        'isAward',
        'register_before',
        'date_start',
        'date_end',
        
    ];

    protected $dates = ["date_start",'date_end','register_before'];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    
    public function participants(){
        return $this->hasMany(Event_participant::class, 'event_id','_id');
 
    }

    public function status(){
        return $this->hasOne(Event_status::class, 'event_id','_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class, 'event_id','_id');
    }

    public function summary(){
        return $this->hasOne(Summary::class, 'event_id','_id');
    }

    public function attendees(){
        return $this->hasMany(Attendees::class, 'event_id','_id');
    }

    public function category(){
        return $this->hasOne(System_settings::class, '_id','system_settings_id');

    }

    public function audit(){
        return $this->hasMany(Auditor_event::class, 'event_id','_id');
    }
    public function audit_item(){
        return $this->hasMany(Audit_item::class, 'event_id','_id');
    }

    public function audit_mark(){
        return $this->hasMany(Audit_mark::class, 'event_id','_id');
    }

    public static function getEvent($event_id){
        $event = Event::find($event_id);
        $eventcollection = collect($event);

        if($eventcollection->get('date_start')) $eventcollection['date_start'] = Carbon::parse($eventcollection->get('date_start'))->format('d/m/Y');
        if($eventcollection->get('date_end')) $eventcollection['date_end'] = Carbon::parse($eventcollection->get('date_end'))->format('d/m/Y');
        if($eventcollection->get('register_before')) $eventcollection['register_before'] = Carbon::parse($eventcollection->get('register_before'))->format('d/m/Y');




        $eventcollection->put('participants',
            collect($event->participants)->map(function($participant){
                return $participant->roles_id;
            })
        )
        ->put('program', ($event->category) ? $event->category->name : "No Category")
        ->put('penazirs',
                collect($event->audit)->map(function($collect){
                    return $collect->user_id;
                })
        )
        ->put('penaziran',
                collect($event->audit_item)->map(function($collect){
                    return $collect->name;
                })
        )
        ->put('status', ($event->status) ? $event->status->status : "No Status")
        ->put('expenses',
            collect($event->expenses)->map(function($collect){
                return [
                    'type' => $collect->expenses_type_id,
                    'reason'=>$collect->payment_details_id,
                    'value' => $collect->expenses
                ];
            })
    );



       return $eventcollection;
    }
   
    public static function createEvent(Request $request){
       
        $event = $request->only('name' ,'event_mode' ,'location' ,'seats' ,
            'fee' ,'system_settings_id',
        );
        $event_id = $request->event_id;
        $participants = $request->participants;
        $expensestype = $request->only('expenses-type');
        $reasontype = $request->only('reasons-type');
        $expensesfee = $request->only('expenses-fee');
        $bannerImg =  $request->file('bannerimg');
        $logoImg = $request->file('logoimg');
        $isAward = ($request->exists('isAward')) ? 1 : 0;

        if($request->exists('date_start')) $event['date_start'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->date_start." 00:00:00"); 
        if($request->exists('date_end')) $event['date_end'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->date_end." 00:00:00"); 
        if($request->exists('register_before')) $event['register_before'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->register_before." 00:00:00");

        if(empty($event_id)){
            $event_id =Event::create(array_merge(
            ['isAward'=> $isAward],$event))['_id'];
            Event_status::create(['event_id'=>$event_id , 'pending_by' => Auth::id(), 'status' => $request->status]);
        }else{
            Event::find($event_id)->update(array_merge(['isAward'=> $isAward],$event));
            Event_status::where('event_id',$event_id)->update(['pending_by' => Auth::id(), 'status' => $request->status]); 
            Event::deleteRelatedEventUtils($event_id);

        }


        if(!empty($event_id)){
            if($bannerImg)  DocumentController::upload_eventImg('bannerImg',$bannerImg,$event_id);
            if($logoImg)  DocumentController::upload_eventImg('logo',$logoImg,$event_id);

            if(!empty($participants)) foreach ($participants as $participant) { Event_participant::create(['event_id' => $event_id,'roles_id' => $participant ]); }
            if($expensestype){
                for ($x = 0; $x < count($expensestype['expenses-type']) ; $x++) {
                    if($expensestype['expenses-type'][$x] != null && $reasontype['reasons-type'][$x])
                            Expenses::create(['event_id' => $event_id,
                                    'expenses_type_id' => $expensestype['expenses-type'][$x],
                                    'payment_details_id' => $reasontype['reasons-type'][$x],
                                    'expenses' => $expensesfee['expenses-fee'][$x],
                                    ]);
                                    
                }
            }
            
            if($isAward){
                $penazirans = array_filter($request->penazirans);
                $penazirs = $request->penazir;
              
                if(!empty($penazirans)) foreach ($penazirans as $penaziran) { Audit_item::create(['event_id' => $event_id,'name' => $penaziran ]); }
                if(!empty($penazirs)) foreach ($penazirs as $penazir) { Auditor_event::create(['event_id' => $event_id,'user_id' => $penazir ]); }

            }
            
        }
      return $event_id;
    }

    private static function deleteRelatedEventUtils($event_id){
        Event_participant::where('event_id', $event_id)->delete();
        Expenses::where('event_id', $event_id)->delete();
        Audit_item::where('event_id', $event_id)->delete();
        Auditor_event::where('event_id', $event_id)->delete();
        
    }

    public static function deleteEvent($event_id){
        try {
            $event = Event::find($event_id);
            $event->participants()->delete();
            $event->status()->delete();
            $event->expenses()->delete();
            $event->attendees()->delete();
            $event->audit()->delete();
            $event->audit_item()->delete();
            $event->delete();
            return true;

        } catch (Throwable $e) {
            return false;
        }

    }

   

   
}

