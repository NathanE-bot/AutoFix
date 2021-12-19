<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('NamaLengkap');
            $table->string('Email')->unique();
            $table->string('password');
            $table->date("TanggalLahir");
            $table->string('NomorHP');
            $table->string('AlamatUser');
            $table->integer('Role')->default('1');
            $table->string("profile_picture");
            $table->timestamp('email_verified_at');
            $table->boolean("isActive")->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
