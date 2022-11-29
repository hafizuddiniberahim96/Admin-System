<?php

namespace App\Models\Event\Audit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Event\Event;
use App\Models\User;


class Auditor_event extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'auditor_event';

    protected $fillable = [
        'event_id',
        'user_id',  
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    
    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }

    public function user(){
        return $this->hasOne(User::class,'_id','user_id');
    }

}
