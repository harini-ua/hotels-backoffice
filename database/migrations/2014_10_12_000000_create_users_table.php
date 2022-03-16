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

            $table->string('title');
            $table->string('firstname');
            $table->string('lastname');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->string('company_name');
            $table->string('phone');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->text('address');
            $table->boolean('status')->comment('0-inactive, 1-active');
            $table->dateTime('last_login');
            $table->boolean('newsletter');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('language_id');
            $table->ipAddress('ip_address');

            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('language_id')->references('id')->on('languages');
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
