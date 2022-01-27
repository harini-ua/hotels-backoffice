<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('state');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_status_id');
            $table->boolean('active');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->bigInteger('hotels_count');
            $table->smallInteger('popularity');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_status_id')->references('id')->on('cities_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
