<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Event\Event;
use App\Models\Event\Event_expense as Expense;




class Event_summary extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'event_summary';

    protected $fillable = [
        'event_id',
        'expenses_id',
        'expenses_used',
        'overBudget',
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    
    public function event(){
        return $this->belongsTo(Event::class, 'event_id', '_id');
    }

    public function expensesDetail(){
        return $this->hasOne(Expense::class, '_id', 'expenses_id');
    }
}
