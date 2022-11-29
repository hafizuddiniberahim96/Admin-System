<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\System_settings;


class Event_expense extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'event_expenses';

    protected $fillable = [
        'event_id',
        'expenses_type_id',   # Expenses Type
        'payment_details_id', # Payment Reason
        'expenses',
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    
    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }

    public function expensesType(){
        return $this->hasOne(System_settings::class, '_id', 'expenses_type_id');
    }
    public function paymentDetails(){
        return $this->hasOne(System_settings::class, '_id', 'payment_details_id');
    }
}
