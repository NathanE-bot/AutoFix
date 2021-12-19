<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationalBengkelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operational_bengkels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('BengkelID');
            $table->foreign('BengkelID')->references('id')->on('bengkels');
            $table->string('HariOperational');
            $table->time('JamBuka');
            $table->time('JamTutup');
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
        Schema::dropIfExists('operational_bengkels');
    }
}
