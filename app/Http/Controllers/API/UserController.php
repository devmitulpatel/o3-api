<?php

namespace App\Http\Controllers\API;

use App\Base\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\OptionResource;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{

    public function update(UpdateUserRequest $request, User $user)
    {
        return UserResource::make($request->presist($user));
    }

    public function check()
    {
        return UserResource::make(auth()->user());
    }

    public function options(){
        return OptionResource::make(RegisterUser::getOptions());
    }

}
