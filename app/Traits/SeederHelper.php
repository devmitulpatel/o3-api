<?php


namespace App\Traits;


trait SeederHelper
{


    private function ForEach($class,array $data,\Closure $query=null):array{
        $created=[];
        foreach ($data as $v){
            $model=$class::factory()->create($v);
            if($query!==null)$model=$query($model);
            $created[]=$model;
        }
        return$created;
    }

}