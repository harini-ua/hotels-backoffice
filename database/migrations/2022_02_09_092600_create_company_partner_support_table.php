<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPartnerSupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_partner_support', function (Blueprint $table) {
            $table->id();
            $table->boolean('partner_support')->default(0);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('company_partner_id');
            $table->unsignedBigInteger('currency_id');
            $table->boolean('price_grid')->default(0);
            $table->json('prices');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('company_partner_id')->references('id')->on('company_partner');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_partner_support');
    }
}
