<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReversiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reversibles', function (Blueprint $table) {
            $table->id();
            $table->string('reversible_type');
            $table->unsignedBigInteger('reversible_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->longText('data');
            $table->timestamps();
        });

        Schema::create('reversible_logs',function ($table){
            $table->id();
            $table->string('reversible_type');
            $table->unsignedBigInteger('reversible_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->longText('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reversibles');
    }
}
