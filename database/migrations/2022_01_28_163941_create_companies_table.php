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
            $table->string('holder_name');
            $table->string('company_name');
            $table->boolean('category');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('status')->default(1)
                ->comment('0-inactive, 1-active, 2-pending');
            $table->tinyInteger('level')->default(1)
                ->comment('0-without level, 1-fist level, 2-second level');
            $table->boolean('vat')->default(0);
            $table->boolean('newsletter')->default(0);
            $table->tinyInteger('login_type')->default(\App\Enums\AccessCodeType::NO_CODE);
            $table->integer('access_codes')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('email', 'unique_email');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('company');
    }
}
