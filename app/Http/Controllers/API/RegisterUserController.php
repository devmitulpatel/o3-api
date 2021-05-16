<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\CompanyTypeResource;
use App\Http\Resources\PlainResource;
use App\Models\CompanyType;
use App\Models\Role;
use App\Traits\ModelHelper;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{

    use ModelHelper;
    public function store(RegisterUserRequest $request,Role $type){

        $request->presist($type);
        return "success";
    }

    public function registerData(){

        return PlainResource::make([
                    'company_type'=>CompanyTypeResource::collection(CompanyType::query()->active()->get())
                                         ]);

    }
}
