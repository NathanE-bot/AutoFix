<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id("shopId");
            // $table->id("adminId");
            $table->string("shopName")->nullable();
            $table->string("shopAddress")->nullable();
            $table->string("LogoURL")->nullable();
            $table->string("operationalHour")->nullable();
            $table->string("gallery")->nullable();
            $table->string("contactPhoneNumber")->nullable();
            $table->string("contactEmailAddress")->unique();
            
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
        Schema::dropIfExists('shops');
    }
}
