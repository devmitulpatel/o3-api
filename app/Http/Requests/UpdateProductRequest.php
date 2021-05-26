<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        //return $this->user()->can('ability', 'model');
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function presist()
    {
        //
    }
}
