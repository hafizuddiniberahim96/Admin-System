<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\Model;
use Carbon\Carbon;

class Document_upload extends Model
{

    protected $connection = 'mongodb';
    protected $tableName = 'document_uploads';


        #type : General, private and certificate
        # General : admin
        # private : users
        # certificate : admin for events
    protected $fillable = [
        'type',
        'tableName',
        'refer_id',
        'desc',
        'name', 
        'path'
    ];

    protected $hidden = [
        'tableName',
        'refer_id',
        'updated_at'
    ];

    public static function retrieve_file($tableName, $refer_id){
        return Document_upload::where('tableName',$tableName)->where('refer_id',$refer_id)->get();
    }

    public static function upload_file($tableName, $refer_id, $type, $folder, $file, $desc='-'){

        #path example :: /nric/user_id
        #event/user_id
        /**
         * path : 
         * GENERAL::
         * for general admin
         * private ::
         * nric - for nric
         * report/{user_ids} - student/institutions report
         *  for private stuff
         * Certficate ::
         * events /{event_id} - certificate only
         * Penaziran ::
         * penaziran/{{audit_mark_id}}
         */
        $name = $file->getClientOriginalName();
        $extension = $file->extension();
        $path =  join('/', array($type,$folder));
        $filename= (in_array($folder,array('nric'))) ? explode("/",$path)[1].'_'.$refer_id.'.'.$extension 
                :  explode("/",$path)[1].'_'.Carbon::now()->format("m-d-Y H:i:s.u").'.'.$extension;
        
        $storage = Storage::disk('local')->putFileAs(
            $path,
            $file,
            $filename
        );
        //replace 
        if(Document_upload::where('tableName',$tableName)->where('refer_id',$refer_id,)->first() &&  in_array($folder,array('nric')))
        {
            $results=Document_upload::where('tableName',$tableName)->where('refer_id',$refer_id)
                ->update([
                    'name' => $name,
                    'path' => explode("/",$path)[0].'/'.$filename
                ]);
        }
        else{
            $results= Document_upload::create([
                    'type' => $type,
                    'tableName'=> $tableName,
                    'refer_id' => $refer_id,
                    'name' => $name,
                    'path' => explode("/",$path)[0].'/'.$filename,
                    'desc' => $desc,
                ]);
        }

        return $results;
    }



}
