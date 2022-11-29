<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Company;



class Company_product extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'company_products';

    protected $fillable = [
        'company_id',
        'name',
    ];

    protected $hidden = [
        'company_id',
        'updated_at',
    ];


    public function company(){
        return $this->belongsTo(Company::class, 'company_id', '_id');

    }
}
