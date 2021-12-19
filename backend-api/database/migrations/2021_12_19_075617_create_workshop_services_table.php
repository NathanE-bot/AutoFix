<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workshopDetailID');
            $table->foreign('workshopDetailID')->references('id')->on('workshop_details');
            $table->string('servicType');
            $table->string('servicDetail');
            $table->string('price');
            $table->string('time');
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
        Schema::dropIfExists('workshop_services');
    }
}
