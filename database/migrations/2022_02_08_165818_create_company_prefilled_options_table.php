<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPrefilledOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_prefilled_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->tinyInteger('adults_count')->default(1);
            $table->tinyInteger('nights_count')->default(1);
            $table->tinyInteger('rooms_count')->default(1);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->boolean('checkout_editable')->default(1)
                ->comment('0-not editable, 1-editable');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('country_id')->references('id')->on('countries');
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
        Schema::dropIfExists('company_prefilled_options');
    }
}
