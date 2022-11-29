<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class User_roles extends Model
{

    protected $connection = 'mongodb';
    protected $table = 'user_roles';

    protected $fillable = [
        'name',
       
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    
}
