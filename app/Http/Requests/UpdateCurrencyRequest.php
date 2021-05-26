<?php

namespace App\Http\Requests;

use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Currency::class);
    }

    public function rules()
    {
        return [
            'name'=>[''],
            'symbol'=>[''],
            'base_rate'=>[''],
        ];
    }

    public function presist(Currency $currency)
    {
        $currency->update($this->validated());
        return $currency;
    }
}
