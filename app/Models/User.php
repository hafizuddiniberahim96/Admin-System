<?php

namespace App\Models;
use  App\Http\Controllers\DocumentController;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use App\Models\User_roles as Roles;
use App\Models\User_details as Details;
use App\Models\User_occupation as Occupation;

use App\Models\Institution;
use App\Models\Company;
use App\Models\Document_upload;
use App\Models\Supervision;



use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\LockableTrait;


class User extends Authenticatable 
{
    use LockableTrait;
    protected $connection = 'mongodb';

    /**
         * Status   isActive    registerComplete    hasApproved
         * init         1                0                   0           -- pending at user side, not show at admin
         * pending      1               1               0           -- pending at admin
         * approve      1               1               1           -- approved by admin
         * reject       1               0               1           -- pending at user to complete the user profile
         * cancel       -- delete user from db
         * 
         */

   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nric',
        'password',
        'roles_id',
        'institution_id',
        'email',
        'lockout_time',
        'registerComplete',
        'isActive',
        'isApproved',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Roles::class, '_id','roles_id');
    }

    public function details(){
        return $this->hasOne(Details::class,'user_id','_id');
    }

    public function occupation(){
        return $this->hasOne(Occupation::class,'user_id','_id');
    }

    public function institution(){
        return $this->hasOne(institution::class, '_id','institution_id');
    }

    public function company(){
        return $this->hasOne(Company::class,'user_id','_id');
    }

    public function mentor(){
        return $this->hasMany(Supervision::class,'mentor_id','_id');
    }
    
    public function mentee(){
        return $this->hasOne(Supervision::class,'mentee_id','_id');
    } 



    public static function deleteRecord($id){
       
        if(!empty(User::find($id))){
            User::find($id)->delete();
            Details::where('user_id',$id)->delete();
        }
        return true;

    }

    public function nricFile(){
        return $this->hasOne(Document_upload::class, 'refer_id', '_id');
    }

  


    public static function getUser($user){
        $collection = collect($user);
       
        $collection= $collection->merge(collect(
            ['role' => $user->role->name,
            "institution" => ($user->institution) ? collect($user->institution)->get('name') : '', 
            'state_name'=>  ($user->details) ? collect($user->details->state)->get('name') : "", 
            'region_name' => ($user->details) ?collect($user->details->region)->get('name') : ''
       ]))
        ->merge(collect($user->details)->map(function($details){
            return $details;
        }))
        ->merge(collect($user->occupation)->map(function($occupation){
            return $occupation;
        }));
        
        return $collection;
    }

    public static function updateUser(Request $request,$id){
        
        $user = $request->only('email','institution_id');
        $user_details = $request->only('fullName','phoneNumber','address','state_id','region_id','postcode','dateofbirth');
        $user_occupation = $request->only('eduLevel','Occupation','position','expertise','start_year','end_year');
        $nric_file = $request->file('uploadNRIC');
        $profile_img =  $request->file('profileImg');


        if(!empty($user)) User::where('_id',$id)->update($user);

        if(Details::where('user_id',$id)->exists()){
            Details::where('user_id',$id)->update($user_details);
        }
        else if(!empty( $user_details) > 0)  Details::create(array_merge(['user_id'=>$id],$user_details));

        if(Occupation::where('user_id',$id)->exists()){
            Occupation::where('user_id',$id)->update($user_occupation);
        }
        else if(!empty($user_occupation) > 0)  Occupation::create(array_merge(['user_id'=>$id],$user_occupation));

        //Upload File
        if($nric_file) $storage= Document_upload::upload_file('users',$id,'private','nric',$request->file('uploadNRIC'));
        if($profile_img) DocumentController::upload_profileImg($request->file('profileImg'),$id);

        if(User::where(['_id' => $id, 'isApproved'=>1,'registerComplete'=>0])->first()){
            User::where(['_id' => $id, 'isApproved'=>1,'registerComplete'=>0])->update(['isApproved' => 0,'registerComplete'=>1]);
        }else   User::where('_id',$id)->update(['registerComplete'=>1]);
      
        return true;
    }
    

    
   
}
