<?php

namespace App\Providers;

use App\Base\Item;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class Layer1 extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {


//        App::bind('ErpItem',function() {
//            return   new \App\Base\Item;
//        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
