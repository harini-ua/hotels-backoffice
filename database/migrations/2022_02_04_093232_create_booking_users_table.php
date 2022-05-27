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
            $table->string('title');
            $table->string('username');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status')->default(1)
                ->comment('0-inactive, 1-active');
            $table->boolean('hide_book_now')->default(0)
                ->comment('0-inactive, 1-active');
            $table->boolean('hide_my_account')->default(0)
                ->comment('0-inactive, 1-active');
            $table->boolean('invoice_allowed')->default(0)
                ->comment('0-inactive, 1-active');
            $table->boolean('secure_payment')->default(0)
                ->comment('0-inactive, 1-active');
            $table->boolean('newsletter')->default(0)
                ->comment('0-inactive, 1-active');
            $table->string('company_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('distributor_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('country_id');
            $table->string('city')->nullable();
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('currency_id');
            $table->string('partner_gitfcard_id', 500)->nullable();
            $table->string('partner_gitfcard_code', 500)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('distributor_id')->references('id')->on('distributors');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('currency_id')->references('id')->on('currencies');
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
