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
        'ref_code'
    ];


    public function companyType(){
        return $this->belongsTo(CompanyType::class);
    }

    public function companyAssociates(){
        return $this->belongsToMany(User::class,'company_associates','company_id','user_id');
    }



}
