<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class Item extends Facade
{

    protected static function getFacadeAccessor()
    {
        return new Item();
    }

}