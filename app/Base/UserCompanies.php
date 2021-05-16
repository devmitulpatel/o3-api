<?php


namespace App\Base;


use App\Models\Company;
use App\Models\User;

class UserCompanies
{


    public static function getCompanies(User $user=null,$pagination=true){

        if($user===null)$user=auth()->user();
        $companies=$user->company()->pluck('company_id');
        $companies=Company::whereIn('id',$companies);
        return ($pagination)?$companies->paginate():$companies;

    }

}