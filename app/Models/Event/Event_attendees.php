<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Event\Event;
use App\Models\Event\Event_attendance;
use App\Models\User;
use App\Models\Event\Audit\Audit_mark;


class Event_attendees extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'event_attendees';

    protected $fillable = [
        'event_id',
        'user_id',  
        'status',
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }


    public function participant(){
        return $this->hasOne(User::class, '_id', 'user_id');
    }

    public function attendance(){
        return $this->hasMany(Event_attendance::class, 'user_id', 'user_id');
    }

    public function auditStatus(){
        return $this->hasOne(Audit_mark::class, 'attendees_id', '_id');
    }
}
