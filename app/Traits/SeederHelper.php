<?php


namespace App\Traits;


use Closure;

trait SeederHelper
{


    private function ForEach($class,array $data,Closure $query=null,$load=[]):array{
        $created=[];
        foreach ($data as $v){
            $model=$class::factory()->create($v);

            if($query!==null)$model= $query($model) ;
           // if(count($load))dd($model->load($load)->toArray());
            if($model==null)dd($query);
            $created[]=$model->load($load);
        }
        return$created;
    }

}