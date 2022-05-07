<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyHomepageOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_homepage_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('theme_id');
            $table->string('logo');
            $table->unsignedBigInteger('carousel_id');
            $table->unsignedBigInteger('teaser_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('theme_id')->references('id')->on('company_theme');
            $table->foreign('carousel_id')->references('id')->on('company_carousels');
            $table->foreign('teaser_id')->references('id')->on('company_teasers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_homepage_options');
    }
}
