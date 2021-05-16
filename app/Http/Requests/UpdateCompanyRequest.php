<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use App\Base\Company as CompanyBase;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return  $this->route('company') && $this->user()->can('update', $this->route('company'));
    }

    public function rules()
    {
        return [
            'name'=>['required','max:100'],
            'company_type'=>['exists:company_types,id'],
            'pan'=>[''],
            'tan'=>[''],
            'gst'=>[''],
            'register_no'=>[''],
        ];
    }

    public function presist(Company $company)
    {

        resolve(CompanyBase::class,['company'=>$company])->update($this->validated());

    }
}
