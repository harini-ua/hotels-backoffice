<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageFieldTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_field_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('name');
            $table->string('translation');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_duplicate')->default(0)
                ->comment('1-duplicate; 0-correct');
            $table->timestamps();

            $table->foreign('field_id')->references('id')->on('page_fields');
            $table->foreign('page_id')->references('id')->on('pages');
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
        Schema::dropIfExists('page_field_translations');
    }
}
