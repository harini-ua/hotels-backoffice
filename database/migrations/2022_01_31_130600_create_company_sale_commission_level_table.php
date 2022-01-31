<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySaleCommissionLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_sale_commission_level', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sale_office_default')->default(null);
            $table->unsignedBigInteger('sale_office_country_id')->default(null);
            $table->mediumInteger('commission');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sale_office_country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_sale_commission_level');
    }
}
