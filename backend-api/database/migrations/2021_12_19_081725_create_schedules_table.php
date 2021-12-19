<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('id')->on('users');
            $table->unsignedBigInteger('workshopID');
            $table->foreign('workshopID')->references('id')->on('workshops');
            $table->string('workshopName');
            $table->string('workshopAddress');
            $table->date('scheduleDate');
            $table->time('scheduleTime');
            $table->string('carModel');
            $table->string('carType');
            $table->integer('timeEstimation');
            $table->integer('priceEstimation');
            $table->string('schedulleStatus');
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
        Schema::dropIfExists('schedules');
    }
}
