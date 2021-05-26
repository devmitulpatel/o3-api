<?php

namespace App\Http\Requests;

use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;

class StoreCurrencyRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Currency::class);
    }

    public function rules()
    {
        return [
            'name'=>['required'],
            'symbol'=>['required'],
            'base_rate'=>['required'],
        ];
    }

    public function presist():Currency
    {
        return Currency::create($this->validated());
    }
}
