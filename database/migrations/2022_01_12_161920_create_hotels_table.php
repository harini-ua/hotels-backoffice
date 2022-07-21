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
            $table->tinyInteger('status')->default(0)
                ->comment('1-new, 2-updated, 3-old, 4-deleted');
            $table->boolean('blacklisted')
                ->comment('0-active, 1-blacklisted');
            $table->smallInteger('rating')->default(0);

            $table->smallInteger('popularity')->default(0);
            $table->smallInteger('priority_rating')->default(0);
            $table->smallInteger('recommended')->default(0);
            $table->smallInteger('special_offer')->default(0);
            $table->smallInteger('other_rating')->default(0);
            $table->mediumInteger('commission')->default(0);

            $table->bigInteger('trip_advisor_rating_id')->default(0);
            $table->bigInteger('trip_advisor_rating_count')->default(0);
            $table->string('trip_advisor_rating_url')->nullable();

            $table->string('name', 1000)->nullable();
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->point('position')->nullable();
            $table->string('located')->nullable();
            $table->string('thumbnail_image')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')->references('id')->on('cities');
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
