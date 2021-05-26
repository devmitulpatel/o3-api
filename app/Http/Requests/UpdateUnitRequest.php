<?php

namespace App\Http\Requests;

use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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

    public function presist(Unit $unit)
    {
        $unit->update($this->validated());
    }
}
