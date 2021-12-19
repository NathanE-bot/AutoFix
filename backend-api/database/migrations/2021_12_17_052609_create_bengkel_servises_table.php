<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBengkelServisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bengkel_servises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('BengkelDetailID');
            $table->foreign('BengkelDetailID')->references('id')->on('bengkel_details');
            $table->string('JenisServis');
            $table->string('ServisDetail');
            $table->integer('Harga');
            $table->integer('Waktu');
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
        Schema::dropIfExists('bengkel_servises');
    }
}
