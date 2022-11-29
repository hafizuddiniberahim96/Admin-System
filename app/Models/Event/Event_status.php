<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;
use App\Models\Event\Event;


class Event_status extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'event_status';

    protected $fillable = [
        'event_id',
        'pending_by',
        'approve_by',
        'reject_by',
        'cancel_by',
        'close_by',
        'finish_by',
        'status',
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    
    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }

    public function pendingBy(){
        return $this->hasOne(User::class, '_id', 'pending_by');
    }

    public function approveBy(){
        return $this->hasOne(User::class, '_id', 'approve_by');
    }

    public function rejectBy(){
        return $this->hasOne(User::class, '_id', 'reject_by');
    }

    public function cancelBy(){
        return $this->hasOne(User::class, '_id', 'cancel_by');
    }
}
