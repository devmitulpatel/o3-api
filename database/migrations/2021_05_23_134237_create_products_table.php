<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        $baseTable=function (Blueprint $table){
            $table->id();
            $table->string('name',50);
            $table->string('symbol',50);
            $table->double('base_rate')->default(1.0);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();
        };

        Schema::create('currencies',function (Blueprint $table)use ($baseTable){
            $baseTable($table);
        });

        Schema::create('units',function (Blueprint $table)use ($baseTable) {
            $baseTable($table);

    });

        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->string('rateable_type');
            $table->unsignedBigInteger('rateable_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('rate')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->string('measurementable_type');
            $table->string('measurementable_id');
            $table->unsignedInteger('unit_id');
            $table->unsignedBigInteger('value')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });


        $baseTable=function ($table){
            $table->id();
            $table->string('name',255);
            $table->string('description',2000)->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('in_stock')->default(0);
            $table->unsignedBigInteger('sold_stock')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        };

        Schema::create('products', function (Blueprint $table)use ($baseTable) {
            $baseTable($table);
        });
        Schema::create('services', function (Blueprint $table)use ($baseTable) {
            $baseTable($table);
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
        Schema::dropIfExists('rates');
        Schema::dropIfExists('measurements');
        Schema::dropIfExists('products');
        Schema::dropIfExists('services');
        Schema::dropIfExists('currencies');
    }
}
