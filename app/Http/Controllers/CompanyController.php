<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\State;
use  App\Models\System_settings;
use  App\Models\Document_upload as Upload;
use App\Models\Company;
use App\Models\Company_product as Product;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Support\Facades\Validator;



class CompanyController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware("can:isUser");
    }

    public function index(){
        $companydetails = collect(Auth::user()->company);
        return view('user.company')
        ->with('status', (!empty($companydetails)) ? 'readonly' : '')
        ->with('company',$companydetails)
        ->with('states',State::get())
        ->with('sectors',System_settings::where('tableName','Service Sector')->get());       
    }

    public function create(Request $request){

        $company = $request->validate([
            'name' => 'required',
            'phoneNumber' => 'required',
            'system_settings_id'  => 'required',
            'email' => 'required',
            'state_id' => 'required',
            'region_id' => 'required',
            'postcode' => 'required',
             'address' => 'required',
            'dateEstablished' => 'required',
            'SSMNo' => 'required',
        ]);
        if(Company::where(['user_id'=>Auth::id()])->first()){
            $companydetails= Company::where(['user_id'=>Auth::id()])->update($company);
            Notify::success("Successfully update company details.", "Success",["closeButton" => true]);
        } 
        else{
            $companydetails=Company::create(array_merge(['user_id'=>Auth::id()],$company));
            Notify::success("Successfully create company details.", "Success",["closeButton" => true]);

        } 
        return back()->with('company',$companydetails);
    }

    public function uploadFile(Request $request){

        $validationRules = array(
            "fields"    => "required|array",
            "fields.*"  => "required|file|max:5120",
        );
        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails())
        {
            Notify::error("Failed upload files.", "Failed",["closeButton" => true]);
            return back()->withErrors($validator);
        }

            $files = $request->file('fields');
            $description = $request->fields_desc;
            foreach ($files as $index => $file) {
                $desc = ($description[$index]) ? $description[$index] : '-' ;
                Upload::upload_file('company',$request->id,'private','company',$file,$desc);
            }
            Notify::success("Successfully upload files.", "Success",["closeButton" => true]);

        return back();
    }

    public function createProduct(Request $request){
        $products = $request->products;
        foreach ($products as $product) {
            Product::create(['company_id' => $request->id,
                             'name' => $product
                            ]);
        }
        Notify::success("Successfully create product.", "Success",["closeButton" => true]);
        return back();

    }

    public function listProducts($company_id){

        $productlist= Product::where('company_id',$company_id)->get();
        return DataTables::of($productlist)
        ->editColumn('created_at', function ($user) {
            return [
                'display' => Carbon::parse($user->created_at)->format('d/m/Y H:i:s A'),
            ];
        })
        ->escapeColumns([])
        ->addIndexColumn()
        ->addColumn('action','
            <a  class="btn btn-labeled btn-danger text-white" type="button"  data-placement="top" data-toggle="tooltip" href="/company/delete-product/{{$_id}}">
                <i class="fa fa-trash"></i>
            </a>  
        
        ')
        ->make(true);
    }

    public function deleteProducts($id){
        Product::find($id)->delete();
        Notify::error("Successfully delete item in products.", "Delete",["closeButton" => true]);

        return back();
    }

    

  

}
