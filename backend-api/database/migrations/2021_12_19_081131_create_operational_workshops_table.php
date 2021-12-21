<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationalWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operational_workshops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workshopID');
            $table->foreign('workshopID')->references('id')->on('workshops');
            $table->date('operationlaDate');
            $table->time('operationalOpenHour');
            $table->time('operationalCloseHour');
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
        Schema::dropIfExists('operational_workshops');
    }
}
