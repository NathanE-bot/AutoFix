<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentationInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentation_insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('insuranceID');
            $table->foreign('insuranceID')->references('id')->on('insurances');
            $table->string('documentationInsuranceName');
            $table->string('documentationPicture');
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
        Schema::dropIfExists('documentation_insurances');
    }
}
