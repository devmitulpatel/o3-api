<?php


namespace App\Traits;


trait ModelHelper
{


    public function scopeActive($query){
        return $query->where('status',true);
    }

    public function id(){
        return $this->id;
    }

}