<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\State;

class Region extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'state_id',
    ];


    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function state()
    {
        return $this->hasOne(State::class, '_id','state_id');
    }


}
