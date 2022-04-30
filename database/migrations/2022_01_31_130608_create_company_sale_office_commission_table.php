<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySaleOfficeCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_sale_office_commission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->smallInteger('level')->default(\App\Enums\Level::First);
            $table->unsignedBigInteger('sale_office_country_id');
            $table->mediumInteger('commission');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('company_sale_office_commission');
    }
}
