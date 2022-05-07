<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCarouselItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_carousel_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carousel_id');
            $table->integer('type')->default(\App\Enums\CarouselType::Image);
            $table->string('image');
            $table->text('text')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('carousel_id')->references('id')->on('company_carousels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_carousel_items');
    }
}
