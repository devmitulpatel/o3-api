<?php

namespace App\Http\Requests;

use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Unit::class);
    }

    public function rules()
    {
        return [
            'name'=>['required'],
            'symbol'=>['required'],

        ];
    }

    public function presist()
    {


        return Unit::create($this->validated());
    }
}
