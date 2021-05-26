<?php


namespace App\Base;


use App\Base\Interfaces\BaseClass;

use App\Base\Interfaces\BaseClassIneterfaces ;
use App\Models\Measurement;
use App\Models\Rate;
use Illuminate\Support\Collection;


class Product extends BaseClass implements BaseClassIneterfaces
{

    public $model=\App\Models\Product::class;

    public $allowedKeyInTable=[
        'name','description','company_id'
    ];
    public $allowedKeyForRelation=['rate','measurement'];
    public $allowedKeyForMeta=['color'];

    public $relationData=[];

    public $relation=[
        'rate'=>Rate::class,
        'measurement'=>Measurement::class,
    ];

    /**
     * Product constructor.
     */
    public function __construct($data=null)
    {
        $this->fixData($data);
        $this->setData($data);
    }


    public function setProduct($data){
        $this->data=$data;
    }
    public function create($data)
    {
        return $this->setData($this->getModel()::create($data));
    }
    public function fixData(&$data){
        $extra=[];
        if(is_array($data)){
            foreach ($data as $key=>$value){
                if(!in_array($key, $this->allowedKeyInTable)){
                    $extra[$key]=$value;
                    unset($data[$key]);
                }
            }
        }

        if(count($extra)) {

            foreach ($extra as $key => $value) {
                if (in_array($key, $this->allowedKeyForMeta)) {
                    $this->getModel()->setMeta($key,(string)$value);
                }elseif (in_array($key,$this->allowedKeyForRelation)){

                    switch ($key){
                        case 'measurement':

                            foreach ($value as $related){
                                $model=$this->getRelated($key);
                                $model->value=$related['value'];
                                $model->unit_id=$related['key'];
                                $this->setRelationData($model,$key);
                            }
                            break;
                        case 'rate':
                                $model=$this->getRelated($key);
                                $model->rate=$related['rate'];
                                $model->currency_id=1;

                            dd($this->getModel()->measurements);
                            break;
                    }

                }
            }
        }

        if(is_array($data) &&count($data))dd($extra);
    }

    public function updateRule():array{

        return [
            'name'=>['required'],
            'description'=>['required'],
            'company_id'=>[],
            'rate'=>['array'],
            'measurement'=>['array'],

        ];
    }

    public function storeRule():array{
        return [
            'name'=>['required'],
            'description'=>['required'],
            'company_id'=>[],
            'rate'=>['array'],
            'measurement'=>['array'],

        ];
    }

    /**
     * @return Collection
     */
    public function getRelationData(): Collection
    {
        return collect($this->relationData);
    }

    /**
     * @param array $relationData
     */
    public function setRelationData( $relationData,$key): void
    {
        $this->relationData[$key][] = $relationData;
    }




}