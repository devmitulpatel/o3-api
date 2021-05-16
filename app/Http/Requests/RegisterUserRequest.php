<?php

namespace App\Http\Requests;

use App\Base\RegisterUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name'=>['required'],
            'last_name'=>['required'],
            'company_name'=>['required'],
            'email'=>['required','unique:users'],
            'gender'=>['required']
        ];
    }

    public function presist($type):void
    {
       resolve(RegisterUser::class,['user'=>User::find(1)])->create($type,$this->validated());

    }


}
