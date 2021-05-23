<?php


namespace App\Traits;


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


}