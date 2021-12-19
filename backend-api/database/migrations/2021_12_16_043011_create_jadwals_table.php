<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UserID');
            $table->foreign('UserID')->references('id')->on('users');
            $table->unsignedBigInteger('BengkelID');
            $table->foreign('BengkelID')->references('id')->on('bengkels');
            $table->string('NamaBengkel');
            $table->string('AlamatBengkel');
            $table->date('TanggalJadwal');
            $table->time('JamJadwal');
            $table->string('ModelMobil');
            $table->string('TipeMobil');
            $table->integer('EstimasiWaktu');
            $table->integer('EstimasiHarga');
            $table->string('StatusJadwal');
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
        Schema::dropIfExists('jadwals');
    }
}
