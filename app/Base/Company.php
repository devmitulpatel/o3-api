<?php


namespace App\Base;


use App\Http\Resources\OptionValueResource;
use App\Models\Company as CompanyModel;
use App\Models\CompanyType;
use App\Models\Ledger as LedgerModel;

class Company
{

    public $company;
    /**
     * Company constructor.
     */
    public function __construct($company=null)
    {
        $this->setCompanyData($company);
    }

    public static function getOptions(){



        return[
            'company_type'=>OptionValueResource::collection(CompanyType::where('status',1)->get())
        ];

    }

    public function delete(){
        if(auth()->user()->can('delete',$this->getCompany())) {
            auth()->user()->company()->detach($this->getCompany()->id);
            $this->getCompany()->delete();
        }
    }

    public function create($input){

        $this->setCompany(CompanyModel::create($this->fixWhenInput($input)));
        auth()->user()->company()->save($this->getCompany());
        return $this->getCompany();
    }


    public function update($input){
        $this->getCompany()->update($this->fixWhenInput($input));
    }

    private function fixWhenInput($input)
    {
        $related=[
            'company_type'=>'company_type_id'
        ];
        foreach ($input as $key=>$value){
            if(array_key_exists($key, $related)){
               $input[$related[$key]]=$value;
               unset($input[$key]);
            }
        }

        return $input;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company): void
    {
        $this->company = $company;
    }

    public function setCompanyData($companyData):void{

        switch (gettype($companyData)){
            case null;
                break;

            case 'array';
                $this->setCompany($this->create($companyData));
                break;

            case 'integer';
                $this->setCompany(CompanyModel::findOrFail($companyData));
                break;

            case 'object';
                if(is_a($companyData,CompanyModel::class))$this->setCompany($companyData);
                break;

            default:

        }

    }


}