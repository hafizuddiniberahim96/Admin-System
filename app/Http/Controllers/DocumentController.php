<?php

namespace App\Http\Controllers;
use  App\Models\User_details as UserDetails;
use  App\Models\Document_upload as Upload;
use App\Models\Event\Event;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class DocumentController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(){
        return view('document.general-document');       
       
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
    public static function upload_eventImg($type,$file,$event_id){
       
        $extension = $file->extension();
        $filename =$type.'_'.$event_id.'.'.$extension;
        $path='public/eventImg';
        $storage = Storage::disk('local')->putFileAs(
            $path,
            $file,
            $filename
        );

        Event::find($event_id)->update([$type =>'eventImg/'.$filename]);       
    }

    public function downloadFile($type,$path){
     
        $folder =  explode("_",$path);
        $download_path = $type.'/'.$folder[0].'/'.$path;
        $file = Storage::disk('local')->get($download_path);
         
        return Response($file)
                ->header('Content-Type', 'application/octet-stream');
    }

    public function uploadFile(Request $request){
        if(Auth::user()->role->name =='admin' && $request->type == 'general')
        {
            $files_upload = $request->validate([
                'fields' => 'required|array',
                'fields.*' => 'required|file|max:5120',
            ]);
            $files = $request->file('fields');
            $description = $request->fields_desc;
            foreach ($files as $index => $file) {
                $desc = ($description[$index]) ? $description[$index] : '-' ;
                Upload::upload_file('users',Auth::id(),'general','general',$file,$desc);
            }
        }
        //for private type please refer Document_upload Model
        return back()->with('message','Upload Successfully!!');
    }

    public function listDocument($type,$tableName,$refer_id){


        $documents = ($type == 'general') ? Upload::where('type',$type)->orderBy('created_at','DESC')->get() : 
                                            Upload::where(['type'      => $type,
                                                            'tableName'=> $tableName,
                                                            'refer_id' => $refer_id
                                                        ])->orderBy('created_at','DESC')->get();

        
        return DataTables::of($documents)
        ->editColumn('created_at', function ($user) {
            return [
                'display' => Carbon::parse($user->created_at)->format('d/m/Y H:i:s A'),
            ];
        })
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action','
        <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/download/{{$path}}">
            <i class="fa fa-download"></i>
        </a>
        @if(  $type=="general")
            @can("isAdmin")
                <a  class="btn btn-labeled btn-danger text-white" type="button"  data-placement="top" data-toggle="tooltip" href="/deleteFileUpload/{{$_id}}">
                    <i class="fa fa-trash"></i>
                </a>  
            @endcan
        @else
            <a  class="btn btn-labeled btn-danger text-white" type="button"  data-placement="top" data-toggle="tooltip" href="/deleteFileUpload/{{$_id}}">
                <i class="fa fa-trash"></i>
            </a>  
        @endif
        
        ')
        ->make(true);

    }

    public function listDocumentDownload($type,$tableName,$refer_id){


        $documents = ($type == 'general') ? Upload::where('type',$type)->orderBy('created_at','DESC')->get() : 
                                            Upload::where(['type'      => $type,
                                                            'tableName'=> $tableName,
                                                            'refer_id' => $refer_id
                                                        ])->orderBy('created_at','DESC')->get();

        
        return DataTables::of($documents)
        ->editColumn('created_at', function ($user) {
            return [
                'display' => Carbon::parse($user->created_at)->format('d/m/Y H:i:s A'),
            ];
        })
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action','
        <a  class="btn btn-labeled btn-success" type="button" data-toggle="tooltip" data-placement="top" title="View" href="/download/{{$path}}">
            <i class="fa fa-download"></i>
        </a>        
        ')
        ->make(true);

    }

    public function deleteDocumentById($id){
        if(Upload::find($id)->exists()) Upload::find($id)->delete();
        Notify::error("Successfully delete file.", "Delete",["closeButton" => true]);


        return back();

    }
}
