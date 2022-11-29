<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Event\Event;
use App\Models\User;

class Event_attendance extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'event_attendance';

    protected $fillable = [
        'event_id',
        'user_id', 
        'attend_on',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }


    public function participant(){
        return $this->hasOne(User::class, '_id', 'user_id');
    }

}
