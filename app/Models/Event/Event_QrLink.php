<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Event\Event;


class Event_QrLink extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'event_qrlinks';

    protected $fillable = [
        'event_id',
        'token', 
        'expires_in',
    ];
    
    protected $dates = ['expires_in'];

    protected $hidden = [
        'updated_at',
    ];

    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }


}
