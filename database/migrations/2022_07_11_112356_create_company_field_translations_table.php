<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyFieldTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_field_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('name');
            $table->string('translation');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_duplicate')->default(0)
                ->comment('1-duplicate; 0-correct');
            $table->timestamps();

            $table->foreign('field_id')->references('id')->on('company_fields');
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('company_field_translations');
    }
}
