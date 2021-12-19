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
            $table->string('fullName');
            $table->string('displayName')->default('');
            $table->string('email')->unique();
            $table->string('password');
            $table->date("DoB");
            $table->string('phoneNumber');
            $table->string('address');
            $table->integer('role')->default('1');
            $table->string("profilePicture")->nullable();
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
