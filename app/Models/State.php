<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class State extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
    ];


    protected $hidden = [
        'created_at',
        'updated_at'
    ];


}
