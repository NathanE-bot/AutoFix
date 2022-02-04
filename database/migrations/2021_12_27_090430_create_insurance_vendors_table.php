<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('id')->on('users');
            $table->string('insuranceName');
            $table->string('phoneNumber');
            $table->string('address');
            $table->string('email');
            $table->string('logo');
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
        Schema::dropIfExists('insurance_vendors');
    }
}
