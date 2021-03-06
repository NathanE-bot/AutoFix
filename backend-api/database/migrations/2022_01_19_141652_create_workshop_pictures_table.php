<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_pictures', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('workshopID');
                $table->foreign('workshopID')->references('id')->on('workshops');
                $table->string('workshopPicture')->nullable();
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
        Schema::dropIfExists('workshop_pictures');
    }
}
