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
            $table->string('state')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->tinyInteger('active')->default(0)
                ->comment('0-inactive, 1-active');
            $table->tinyInteger('status')->default(0)
                ->comment('0-new, 1-old');
            $table->boolean('blacklisted')
                ->comment('0-active, 1-blacklisted');
            $table->point('position');
            $table->bigInteger('hotels_count')->default(0);
            $table->smallInteger('popularity')->default(10);
            $table->mediumInteger('commission')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
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
