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
            $table->string('name');
            $table->string('username')->nullable();
            $table->tinyInteger('usergroup')->nullable();
            $table->text('firstname')->nullable();
            $table->text('lastname')->nullable();
            $table->integer('user_level')->nullable();
            $table->text('language')->nullable();
            $table->tinyInteger('notification')->default('1');
            $table->text('user_otp')->nullable();
            $table->text('user_rest_time')->nullable();
            $table->text('user_otp_time')->nullable();
            $table->text('user_ban')->nullable();
            $table->tinyInteger('user_membership')->default('1');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
