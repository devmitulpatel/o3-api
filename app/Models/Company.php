<?php

namespace App\Models;

use App\Traits\HasTenant;
use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory,ModelHelper;

    protected $with=[
        'companyType',
    ];

    protected $guarded = [];

    protected $fillable=[
        'name',
        'company_type_id',
        'pan',
        'tan',
        'gst',
        'register_no',
    ];


    public function companyType(){
        return $this->belongsTo(CompanyType::class);
    }
//
//    public function bootIfNotBooted()
//    {
//        parent::bootIfNotBooted(); // TODO: Change the autogenerated stub
//        $this->for=auth()->id();
//    }



}