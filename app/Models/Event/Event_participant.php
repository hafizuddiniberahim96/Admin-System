<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Event\Event;
use App\Models\User_roles as Roles;



class Event_participant extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'event_participants';

    protected $fillable = [
        'event_id',
        'roles_id',
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    
    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }

    public function role(){
        return $this->hasOne(Roles::class, '_id', 'roles_id');
    }

    


}
