<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('tti_code');
            $table->unsignedBigInteger('giata_code');
            $table->unsignedBigInteger('hotel_status_id');
            $table->boolean('active');
            $table->smallInteger('rating');
            $table->smallInteger('popularity');
            $table->smallInteger('recommended');
            $table->smallInteger('special_offer');

            $table->string('name');
            $table->string('address');
            $table->string('postal_code');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->longText('description');
            $table->longText('images');
            $table->longText('facilities');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('hotel_status_id')->references('id')->on('hotels_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
