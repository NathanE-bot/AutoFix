<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsuransisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asuransis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UserID');
            $table->foreign('UserID')->references('id')->on('users');
            $table->string('NamaAsuransi');
            $table->string('NamaTertanggung');
            $table->string('NomorHPPengeclaim');
            $table->string('AlamatEmailPengeclaim');
            $table->string('MerekDanTipeKendaraan');
            $table->string('NoRangka');
            $table->string('AlamatPengeclaim');
            $table->string('NomorPolis');
            $table->string('NamaPengemudi');
            $table->string('KecepatanPengemudi');
            $table->string('NomorSIM');
            $table->string('HubunganPengemudi');
            $table->string('TempatKejadian');
            $table->string('KeteranganKendaraan');
            $table->date('TanggalKejadian');
            $table->time('JamKejadian');
            $table->string('StatusTaxiOnline');
            $table->string('JenisBengkel');
            $table->string('Kronologi');
            $table->string('StatusTabrakan');
            $table->string('KeteranganStatusTabrakan');
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
        Schema::dropIfExists('asuransis');
    }
}
