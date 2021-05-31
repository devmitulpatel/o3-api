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
    public $allowedKeyForRelation=['measurements','rates'];
    public $allowedKeyForMeta=['color'];



    public $relation=[
        'measurements'=>Measurement::class,
        'rates'=>Rate::class,
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
        $this->setData($this->getModel()::create($data));
        $k=0;
        if(array_key_exists($this->allowedKeyForRelation[$k],$this->getRelationData())){
            $this->saveManyRelated($this->allowedKeyForRelation[$k],$this->getRelationData($this->allowedKeyForRelation[$k]));
        }
        $k++;
        if(array_key_exists($this->allowedKeyForRelation[$k],$this->getRelationData())) {

            $relation = $this->allowedKeyForRelation[$k];
            $related = $this->allowedKeyForRelation[$k - 1];
            $unitKey = $this->getRawData()[$relation]['key'];
            $foundMeasurment = array_first(array_where($this->getRawData()[$related], function ($array) use ($unitKey) {
                return $array['key'] == $unitKey;
            }));

            $measurmentModel = $this->getData()->$related()->where('value', $foundMeasurment['value']);
            if ($measurmentModel->count()) {
                $this->saveRelated($relation, array_first($this->getRelationData($this->allowedKeyForRelation[$k])), $measurmentModel->first());

            }
        }
        foreach ($this->getMeta() as $key=>$meta){
            $this->getData()->setMeta($key,$meta);
        }
        return $this->getData() ;
    }

    public function update($data){
        $this->fixData($data);
        $this->getData()->update($data);

        $k=0;
        if(array_key_exists($this->allowedKeyForRelation[$k],$this->getRelationData())){
            $this->updateManyRelated($this->allowedKeyForRelation[$k],$this->getRelationData($this->allowedKeyForRelation[$k]));
        }
        $k++;

      //  dd($this->getRawData()['measurements']);
//        $this->getData()->refresh();
//        $v1=$this->getRawData()['measurements'][0]['value'];
//        $v2=$this->getData()->measurement->toArray()[0]['value'];

       // dd(implode(' ',[$v1,$v2]));

        foreach ($this->getMeta() as $key=>$meta){
            $this->getData()->setMeta($key,$meta);
        }
        return $this->getData();
    }

    public function fixData(&$data){

        $extra=[];
        if(is_array($data)){
            $this->setRawData($data);
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
                    $this->setMeta($key,(string)$value);
                }elseif (in_array($key,$this->allowedKeyForRelation)){

                    switch ($key){
                        case 'measurements':
                            foreach ($value as $related){
                                $model=$this->getRelated($key);
                                $model->value=$related['value'];
                                $model->unit_id=$related['key'];
                                $this->setRelationData($model,$key);
                            }
                            break;
                        case 'rates':
                            $model=null;
                                $model=$this->getRelated($key);
                                $model->rate=$value['rate'];
                                $model->currency_id=1;
                            $this->setRelationData($model,$key);
                            break;
                    }

                }
            }
        }
    }

    public function updateRule():array{

        return [
            'name'=>['required'],
            'description'=>['required'],
            'company_id'=>[],
            'rates'=>['array'],
            'measurements'=>['array'],

        ];
    }

    public function storeRule():array{
        return [
            'name'=>['required'],
            'description'=>['required'],
            'company_id'=>[],
            'rates'=>['array'],
            'measurements'=>['array'],

        ];
    }






}