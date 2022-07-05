<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('name');
            $table->tinyInteger('type')->default(0);
            $table->smallInteger('max_length');
            $table->tinyInteger('is_mobile');
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_fields');
    }
}
