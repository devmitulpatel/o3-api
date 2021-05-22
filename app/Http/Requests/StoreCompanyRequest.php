<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use App\Base\Company as CompanyBase;

class StoreCompanyRequest extends FormRequest
{
    public function authorize()
    {

            return $this->user()->can('create', Company::class);
    }

    public function rules()
    {
        return [
            'name'=>['required','max:100'],
            'company_type'=>['required','exists:company_types,id'],
            'pan'=>['required','unique:App\Models\Company,pan'],
            'tan'=>['nullable','unique:App\Models\Company,tan'],
            'gst'=>['nullable','unique:App\Models\Company,gst'],
            'register_no'=>['nullable','unique:App\Models\Company,register_no'],
        ];
    }

    public function presist()
    {
        $input=$this->validated();

        return resolve(CompanyBase::class)->create($input)->load(['companyType']);

    }
}
