<?php

namespace App\Http\Controllers;
use  App\Models\User_details as UserDetails;
use Illuminate\Support\Facades\Storage;



use Illuminate\Http\Request;


class FileTransferController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
     
    }
   

    public static function upload_profileImg($file,$user_id){
       
        $extension = $file->extension();
        $filename =$user_id.'.'.$extension;
        $path='public/profileImg';
        $storage = Storage::disk('local')->putFileAs(
            $path,
            $file,
            $filename
        );

        UserDetails::where('user_id',$user_id)->update(['profileImg'=>'profileImg/'.$filename]);

       
    }

    public function downloadFile($type,$path){
        
        $folder =  explode("_",$path);
        $download_path = $type.'/'.$folder[0].'/'.$path;
        $file = Storage::disk('local')->get($download_path);
       
        return Response($file)
                ->header('Content-Type', 'application/octet-stream');
    }
}
