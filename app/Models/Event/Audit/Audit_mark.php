<?php

namespace App\Models\Event\Audit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Event\Event;
use App\Models\User;
use App\Models\Event\Audit\Audit_item;
use App\Models\Event\Event_attendees;

class Audit_mark extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'audit_mark';

    protected $fillable = [
        'event_id',
        'auditor_id',   //user_id for auditor   
        'attendees_id',     // attendees
        'audit_item_id',
        'mark',
        'status'
    ];

    protected $hidden = [
        'created_at'
    ];
    
    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }

    public function item(){
        return $this->hasOne(Audit_item::class,'audit_item_id','_id');

    }

    public function auditor(){
        return $this->hasOne(User::class,'_id','auditor_id');
    }

    public function auditee(){
        return $this->hasOne(Event_attendees::class,'_id','attendees_id');
    }
    

  

}
