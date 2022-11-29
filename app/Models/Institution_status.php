<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;
use App\Models\Institution;


class Institution_status extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'institution_status';

    protected $fillable = [
        'isApproved',
        'institution_id',
        'created_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->hasOne(User::class,'_id','created_by');
    }

    public function institution(){
        return $this->belongsTo(Institution::class, 'institution_id', '_id');
    }

    public static function deleteRecord($id){
        $institution_id=Institution_status::find($id)['institution_id'];
        Institution_status::find($id)->delete();
        Institution::find($institution_id)->delete();

        return true;

    }
}
