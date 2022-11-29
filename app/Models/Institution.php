<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\State;
use App\Models\Region;
use App\Models\Institution_status;




class Institution extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'state_id',
        'region_id',
        'type',
        'postcode',
        'address'
    ];


    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function state()
    {
        return $this->hasOne(State::class, '_id','state_id');
    }

    public function region()
    {
        return $this->hasOne(Region::class, '_id','region_id');
    }

    public function status(){
        return $this->hasOne(Institution_status::class,'institution_id','_id');
    }
}
