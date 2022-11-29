<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Supervision extends Model
{
    use HasFactory;
    protected $fillable = [
        'mentor_id',
        'mentee_id',
    ];


    public function mentor(){
        return $this->hasOne(User::class, '_id', 'mentor_id');
    }

    public function mentee(){
        return $this->hasOne(User::class, '_id', 'mentee_id');
    }


}
