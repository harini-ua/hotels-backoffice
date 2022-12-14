<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_content', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();

            $table->unsignedBigInteger('carousel_id')->nullable();
            $table->unsignedBigInteger('teaser_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('carousel_id')->references('id')->on('company_carousels');
            $table->foreign('teaser_id')->references('id')->on('company_teasers');
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_content');
    }
}
