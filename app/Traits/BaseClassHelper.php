<?php


namespace App\Traits;


use App\Base\Product;

trait BaseClassHelper
{

    public $model,$data,$meta;

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }


    public function setMeta($key,$value): void
    {
        $this->meta[$key] = $value;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function setData($data=null){
        $method=implode('',['set',last(explode('\\',static::class))]);

        switch (gettype($data)){
            case null;
                break;

            case 'array';
                $this->$method($this->create($data));
                break;

            case 'integer';
                $this->$method($this->getModel()::findOrFail($data));
                break;

            case 'object';
                if(is_a($data,$this->getModel()))$this->$method($data);
                break;

            default:

        }
    return $this->getData();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function getRelated($key){


        if(array_key_exists($key,$this->getRalation())){
            $modelName=$this->getRalation($key);
            return new $modelName();
        }

    }

    public static function getRules(bool $store=true):array{
        $class=new static();
        $rules=[];
        if($store){
            $rules=array_merge($rules,$class->storeRule());
        }else{
            $rules=array_merge($rules,$class->updateRule());
        }
        foreach ($class->allowedKeyForRelation  as $meta){
            if(!array_key_exists($meta,$rules)) {
                $rules[$meta] = ['array'];
            }
        }
        foreach ($class->allowedKeyForMeta as $related){
            if(!array_key_exists($related,$rules)) {
                $rules[$related] = [];
            }
        }
        return $rules ;
    }

    protected function getRalation($key=null){
        return ($key===null || ($key!==null && !array_key_exists($key,$this->relation)))?$this->relation:$this->relation[$key];
    }


    public function getRelationData($key=null): array
    {
        return (array_key_exists($key,$this->relationData))?$this->relationData[$key]:$this->relationData;
    }

    public function setRelationData($relationData,string $key): void
    {
        $this->relationData[$key][] = $relationData;
    }

    public function saveRelated(string $key,$value,$model=null){
        return ($model!==null)?$model->$key()->save($value): $this->getData()->$key()->save($value);
    }


    public function saveManyRelated(string $key,array $value,$model=null){
        return ($model!==null)?$model->$key()->saveMany($value): $this->getData()->$key()->saveMany($value);
    }

    public function updateRelated(string $key,array $value,$model=null){

    }
    public function updateManyRelated(string $key,array $value,$model=null){

        dd($value);

    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    /**
     * @param array $rawData
     */
    public function setRawData(array $rawData): void
    {
        $this->rawData = $rawData;
    }

}