<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDefaultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_default', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->text('testimonial_heading_1')->nullable();
            $table->text('testimonial_heading_2')->nullable();
            $table->string('main_page_picture')->nullable();
            $table->text('main_page_heading_1')->nullable();
            $table->text('main_page_heading_2')->nullable();
            $table->text('main_page_heading_3')->nullable();
            $table->string('picture_1')->nullable();
            $table->text('text_picture_1')->nullable();
            $table->string('picture_2')->nullable();
            $table->text('text_picture_2')->nullable();
            $table->string('picture_3')->nullable();
            $table->text('text_picture_3')->nullable();
            $table->string('picture_4')->nullable();
            $table->text('text_picture_4')->nullable();
            $table->string('picture_5')->nullable();
            $table->text('text_picture_5')->nullable();
            $table->string('right_heading_1')->nullable();
            $table->text('right_heading_message_1')->nullable();
            $table->string('right_heading_2')->nullable();
            $table->text('right_heading_message_2')->nullable();

            $table->timestamp('updated_at')->nullable();
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
        Schema::dropIfExists('company_default');
    }
}
