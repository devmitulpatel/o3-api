<?php

namespace App\Http\Controllers\API;

use App\Base\Company as CompanyBase;
use App\Base\UserCompanies;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\OptionResource;
use App\Http\Resources\PlainResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(){

        return CompanyResource::collection(UserCompanies::getCompanies());

    }

    public function store(StoreCompanyRequest $request){

        return CompanyResource::make($request->presist());

    }

    public function options(){

        return OptionResource::make(CompanyBase::getOptions());

    }

    public function update(UpdateCompanyRequest $request,Company $company){
        $request->presist($company);
        return 'success';
    }

    public function destroy(Company $company){

        resolve(CompanyBase::class,['company'=>$company])->delete();

        return 'success';
    }


}
