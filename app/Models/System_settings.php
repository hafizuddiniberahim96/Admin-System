<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class System_settings extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'system_settings';

    protected $fillable = [
        'name',
        'tableName'
    ];


    protected $hidden = [
        'updated_at'
    ];
}
