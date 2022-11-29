<?php

namespace App\Models\Event\Audit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Event\Event;

class Audit_item extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'audit_item';

    protected $fillable = [
        'event_id',
        'name',  
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    
    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }

    
}
