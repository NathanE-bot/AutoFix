<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('id')->on('users');
            $table->string('workshopName');
            $table->string('workshopAddress');
            $table->string('workshopPhoneNumber');
            $table->string('workshopEmail');
            $table->string('workshopDescription');
            $table->float('rating',2,1)->default('0')->nullable();
            $table->string('workshopLogo')->nullable();
            $table->string('city');
            $table->string('district');
            $table->string('province');
            $table->decimal('latitude',10, 6);
            $table->decimal('longitude',10, 6);
            $table->string('statusHr')->nullable();
            $table->string('status24Hr')->nullable();
            $table->boolean("isActive")->default(1);
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
        Schema::dropIfExists('workshops');
    }
}
