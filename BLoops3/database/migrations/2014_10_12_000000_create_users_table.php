<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('user_token')->unique();
            $table->string('member_uid')->unique();
            $table->string('fb_uid')->unique();
            $table->string('fb_primary_photo');
            $table->string('username');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('streets');
            $table->string('city');
            $table->string('country');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->integer('connected_to')->unique();
            $table->integer('activation_id')->unique();
            $table->boolean('type');
            $table->boolean('status');
            $table->boolean('synched');
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
