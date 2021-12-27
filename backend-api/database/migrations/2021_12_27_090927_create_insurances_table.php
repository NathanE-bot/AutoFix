<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('id')->on('users');
            $table->unsignedBigInteger('vendorInsuranceID');
            $table->foreign('vendorInsuranceID')->references('id')->on('insurance_vendors');
            $table->string('insuredName');
            $table->string('phoneNumberClaimer');
            $table->string('emailClaimer');
            $table->string('addressClaimer');
            $table->string('carTypeAndBrand');
            $table->string('chassisNumber');
            $table->string('polisNumber');
            $table->string('licensePlateNumber');
            $table->string('driverName');
            $table->string('driverSpeed');
            $table->string('driverRelation');
            $table->string('incidentLocation');
            $table->string('vehicleDescription');
            $table->date('incidentDate');
            $table->time('incidentTime');
            $table->string('taxiOnlineStatus');
            $table->string('workshopType');
            $table->string('chronology');
            $table->string('incidentStatus');
            $table->string('incidentStatusDescription')->nullable();
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
        Schema::dropIfExists('insurances');
    }
}
