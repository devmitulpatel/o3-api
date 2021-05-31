<?php

namespace App\Http\Requests;

use App\Base\Product as ProductBase;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return $this->route('product') && $this->user()->can('update', $this->route('product'));
    }

    public function rules()
    {
        return ProductBase::getRules(false);
    }

    public function presist(Product $product)
    {
        $product=new ProductBase($product);
        return $product->update($this->validated());
    }
}
