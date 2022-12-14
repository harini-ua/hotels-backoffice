<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->boolean('category');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable(); // TODO: Need to be clarified
            $table->unsignedBigInteger('language_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(1)
                ->comment('0-inactive, 1-active, 2-pending');
            $table->tinyInteger('level')->default(1)
                ->comment('0-without level, 1-fist level, 2-second level');
            $table->tinyInteger('sub_companies')->default(0)
                ->comment('0-without sub companies, 1-has sub companies');
            $table->boolean('vat')->default(0);
            $table->boolean('newsletter')->default(1);
            $table->tinyInteger('login_type')->default(\App\Enums\AccessCodeType::NO_CODE);
            $table->integer('access_codes')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('admin_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
