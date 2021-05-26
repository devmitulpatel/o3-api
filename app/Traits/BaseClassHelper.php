<?php


namespace App\Traits;


use App\Base\Product;

trait BaseClassHelper
{

    public $model,$data;

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
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
            $model=$this->getRalation($key);
            return $model;
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
        return ($key===null && ($key!==null && !array_key_exists($key,$this->relation)))?$this->relation:$this->relation[$key];
    }

}