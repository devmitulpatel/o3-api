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
        return $this->getCustomRules($this->route('type'));
    }

    public function presist($type):void
    {
       resolve(RegisterUser::class,[])->create($type,$this->validated());

    }

    private function getCustomRules(int $type=1){
        $rules=[
            'first_name'=>['required'],
            'last_name'=>['required'],
            'company_name'=>['required'],
            'email'=>['required','unique:users'],
            'gender'=>['required']
        ];
        switch ($type){

            case 3:
            $rules['ref_code']=['required'];
                break;


        }

        return $rules;

    }


}
