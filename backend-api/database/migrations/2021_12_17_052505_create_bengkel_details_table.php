<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBengkelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bengkel_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('BengkelID');
            $table->foreign('BengkelID')->references('id')->on('bengkels');
            $table->string('ModelMobil');
            $table->string('TipeMobil');
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
        Schema::dropIfExists('bengkel_details');
    }
}
