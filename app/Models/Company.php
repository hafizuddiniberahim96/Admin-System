<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\State;
use App\Models\Region;
use App\Models\System_settings;

class Company extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'company';

    protected $fillable = [
        'user_id',
        'name',
        'system_settings_id',
        'email',
        'phoneNumber',
        'state_id',
        'region_id',
        'postcode',
        'address',
        'dateEstablished',
        'SSMNo'
    ];


    protected $hidden = [
        'updated_at',
        'created_at'
    ];


    public function state()
    {
        return $this->hasOne(State::class, '_id','state_id');
    }

    public function region()
    {
        return $this->hasOne(Region::class, '_id','region_id');
    }

    public function sector()
    {
        return $this->hasOne(System_settings::class, '_id','system_settings_id');
    }

}
