<?php


namespace App\Base;


use App\Base\Interfaces\BaseClass;

use App\Base\Interfaces\BaseClassIneterfaces as BaseClassIneterfacesAlias;

use function Symfony\Component\String\s;

class Product extends BaseClass implements BaseClassIneterfacesAlias
{

    public $model=\App\Models\Product::class;

    /**
     * Product constructor.
     */
    public function __construct($data)
    {
        $this->setData($data);
    }


    public function setProduct($data){
        $this->data=$data;
    }


    public function create($data)
    {
        return $this->setData($this->getModel()::create($data));
    }
}