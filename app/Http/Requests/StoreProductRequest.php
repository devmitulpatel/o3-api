<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Base\Product as ProductBase;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Product::class);
    }

    public function rules()
    {
        return ProductBase::getRules() ;
    }


    protected function prepareForValidation()
    {

        $this->merge([
                         'company_id' => Company::first()->id,
                     ]);
    }

    public function presist()
    {
        return (new ProductBase($this->validated()))->getData()->load(['measurements','measurements.rates','measurements.rates.currency']);
    }
}
