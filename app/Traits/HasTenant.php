<?php


namespace App\Traits;


trait HasTenant
{

    public static function bootHasTenant(): void
    {
        static::updating(function ($model){
          $model->setFor();
        });
        static::creating(function ($model){
            $model->setFor();
        });
        static::retrieved(function ($model){
            $model->whereIn('for',[auth()->id()]);

        });
    }

    public function setFor(){
        $this->for=auth()->id();
    }

}