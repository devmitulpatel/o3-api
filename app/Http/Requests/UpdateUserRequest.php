<?php

namespace App\Http\Requests;

use App\Base\RegisterUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name'=>['nullable'],
            'last_name'=>['nullable'],
            'company_name'=>['nullable'],
            'email'=>['nullable','exists:users'],
        ];
    }

    public function presist($user):User
    {
          return resolve(RegisterUser::class,['user'=>$user])->update($this->validated())->getUser();
    }


}
