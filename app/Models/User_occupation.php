<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class User_occupation extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $tableName = 'user_occupations';

    protected $fillable = [
        'user_id',
        'eduLevel',
        'occupation',
        'position',
        'expertise',
        'start_year',
        'end_year',
        
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


}
