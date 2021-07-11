<?php


namespace App\Base;


use Illuminate\Support\Facades\Facade;

class Investment extends Facade
{
    public $investmentRaw=[];

    public function new($data){
        $this->investmentRaw=$data;
        $this->dbProcess();
        return $this;
    }


    private function dbProcess(){
        //TODO: Create DB Schema and do entry in DB
    }


}