<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsruanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insruance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('insuranceID');
            $table->foreign('insuranceID')->references('id')->on('insurances');
            $table->string('filePDF');
            $table->date('claimInsuranceDate');
            $table->string('insuranceStatus');
            $table->string('insuranceDescription');
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
        Schema::dropIfExists('insruance_details');
    }
}
