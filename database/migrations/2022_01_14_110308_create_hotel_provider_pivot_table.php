<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelProviderPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_provider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('provider_id');
            $table->string('provider_hotel_code');
            $table->unsignedBigInteger('tti_code');
            $table->unsignedBigInteger('giata_code');
            $table->tinyInteger('status')->default(0)->comment('1-new, 2-old, 3-binded');
            $table->boolean('blacklisted')->default(0)->comment('0-active, 1-blacklisted');
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
        Schema::dropIfExists('hotel_provider');
    }
}
