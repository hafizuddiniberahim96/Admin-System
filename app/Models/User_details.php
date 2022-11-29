<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;
use App\Models\State;
use App\Models\Region;


class User_details extends Model
{
    protected $connection = 'mongodb';
    protected $tableName = 'user_details';


    protected $fillable = [
        'user_id',
        'state_id',
        'region_id',
        'fullName',
        'education',
        'address',
        'postcode',
        'phoneNumber',
        'profileImg',
        
    ];

    protected $hidden = [
        '_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    public function state(){
        return $this->hasOne(State::class, '_id', 'state_id');
    }

    public function region(){
        return $this->hasOne(Region::class,'_id','region_id');
    }


}
