<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status')->default(1)
                ->comment('0-inactive, 1-active');
            $table->string('company_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('distributor_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('country_id');
            $table->string('city')->nullable();
            $table->unsignedBigInteger('language_id');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('distributor_id')->references('id')->on('distributors');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('country_id')->references('id')->on('countries');
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
        Schema::dropIfExists('booking_users');
    }
}
