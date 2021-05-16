<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\PlainResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebugController extends Controller
{
    public function allUser(){
        return UserResource::collection(User::with(['company'])->where('active',true)->oldest()->paginate());
    }

    public function allCompanies(){
        return CompanyResource::collection(Company::query()->active()->paginate());
    }

    public function getUser(User $user){
        return UserResource::make($user->load(['company']));
    }

    public function loginAsUser(User $user){
        auth()->loginUsingId($user->id);
        return UserResource::make(auth()->user()->load('company'),true)->withToken()->secured();
    }
}
