<?php


namespace App\Base;

/**
 * @method static mixed create(array $data)
 */


use App\Traits\BaseClassHelper;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;

/**
 * Class Items
 * @package App\Base
 */
class Item
{
    use BaseClassHelper;
    private array $rawInputData=[];
    private array $filteredData=[];
    public static $resolvedClass=null;
    public function _create($data){
        $this->filterData($data);
        return $this;
    }



    private function filterData($data):void{
        $this->setRawInputData($data);

        $this->setFilteredData($data);
    }

    /**
     * @return mixed
     */
    public function getRawInputData($key=null):Mixed_
    {
        return ($key!=null && array_key_exists($key,$this->rawInputData))?$this->rawInputData[$key]:$this->rawInputData;
    }

    /**
     * @param mixed $rawInputData
     */
    public function setRawInputData($rawInputData,$key=null): void
    {
        if($key!=null&&$key<count($this->getRawInputData())){
            $this->rawInputData[$key]=$rawInputData;
        }else{$this->rawInputData = $rawInputData;}
    }

    /**
     * @return array
     */
    public function getFilteredData(): array
    {
        return $this->filteredData;
    }

    /**
     * @param array $filteredData
     */
    public function setFilteredData(array $filteredData): void
    {
        $this->filteredData = $filteredData;
    }


}