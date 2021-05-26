<?php


namespace App\Traits;


use App\Models\Company;

trait HasCompany
{

    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }

}