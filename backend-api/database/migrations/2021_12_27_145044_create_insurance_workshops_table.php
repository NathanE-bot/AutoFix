<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_workshops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendorInsuranceID');
            $table->foreign('vendorInsuranceID')->references('id')->on('insurance_vendors');
            $table->string('insuranceWorkshopName');
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
        Schema::dropIfExists('insurance_workshops');
    }
}
