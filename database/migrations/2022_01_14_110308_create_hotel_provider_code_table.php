<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelProviderCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_provider_code', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('provider_id');
            $table->string('provider_hotel_code');
            $table->unsignedBigInteger('tti_code');
            $table->unsignedBigInteger('giata_code');
            $table->tinyInteger('status')->comment('1-new, 2-old, 3-binded');
            $table->boolean('blacklisted')->comment('0-active, 1-blacklisted')->default(0);
            $table->string('hotel_name', 1000);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->foreign('provider_id')->references('id')->on('providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_provider_code');
    }
}
