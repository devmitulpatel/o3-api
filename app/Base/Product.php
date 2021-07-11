<?php


namespace App\Base;


use App\Base\Interfaces\BaseClass;

use App\Base\Interfaces\BaseClassIneterfaces ;
use App\Models\Measurement;
use App\Models\Rate;
use Exception;
use Illuminate\Support\Collection;
use PhpParser\Builder;


class Product extends BaseClass implements BaseClassIneterfaces
{

    public $model=\App\Models\Product::class;

    public $allowedKeyInTable=[
        'name','description','company_id'
    ];
    public $allowedKeyForRelation=['measurements','rates'];
    public $allowedKeyForMeta=['color','company'];


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
            $foundMeasurment=$this->saveManyRelated($this->allowedKeyForRelation[$k],$this->getRelationData($this->allowedKeyForRelation[$k]));
        }
        $k++;

        if(array_key_exists($this->allowedKeyForRelation[$k],$this->getRelationData())) {
            $relation = $this->allowedKeyForRelation[$k];
            $related = $this->allowedKeyForRelation[$k - 1];
            $unitKey = $this->getRawData()[$relation]['key'];
            $foundMeasurment=$this->getData()->$related()
                ->where('unit_id',$this->getRawData()[$relation]);
            $foundMeasurment->first()->addRate( array_first($this->getRelationData($this->allowedKeyForRelation[$k])));

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
        $this->updateManyRelated($this->allowedKeyForRelation[$k],$this->getRelationData($this->allowedKeyForRelation[$k]),'unit_id');
    }
        $k=$k+1;
        if(array_key_exists($this->allowedKeyForRelation[$k],$this->getRelationData())){

            $measure=$this->getData()->{$this->allowedKeyForRelation[$k-1]}();
            $hasRatesMeasrement=$measure->whereHas('rates',function ($data){

                try {
                    return $data;
                }catch (Exception $e){
                    return $data;
                }

            });

            if($hasRatesMeasrement->count()>0)$hasRatesMeasrement->get()->first()
                ->removeAllRate();
            $this->getData()->{$this->allowedKeyForRelation[$k-1]}()
                ->where('unit_id',(int) $this->getRawData()['rates']['key'])
                ->first()->addRate($this->getRawData()['rates']['rate']);

            foreach ($this->getMeta() as $key=>$meta){
                $this->getData()->setMeta($key,$meta);
            }


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