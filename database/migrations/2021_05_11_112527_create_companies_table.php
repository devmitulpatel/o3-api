<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('ref_code',12);
            $table->string('name',255);
            $table->string('pan')->nullable();
            $table->string('tan')->nullable();
            $table->string('gst')->nullable();
            $table->string('register_no')->nullable();
            $table->unsignedBigInteger('company_type_id');
            $table->unsignedBigInteger('subscription_type_id')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('claimed_at')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('companies');
    }
}
