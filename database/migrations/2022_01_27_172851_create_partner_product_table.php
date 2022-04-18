<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->unsignedBigInteger('meal_plan_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('partner_id');
            $table->double('price', 8, 2);
            $table->double('partner_pay_price', 8, 2);
            $table->mediumInteger('partner_commission');
            $table->boolean('price_filter');
            $table->double('price_min', 8, 2);
            $table->double('price_max', 8, 2);
            $table->boolean('star_filter');
            $table->smallInteger('star_min');
            $table->smallInteger('star_max');
            $table->double('commission_min', 8, 2);
            $table->smallInteger('nights');
            $table->smallInteger('adults');
            $table->boolean('sold_online');
            $table->boolean('sold_retail');
            $table->string('sku')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('meal_plan_id')->references('id')->on('meal_plans');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('partner_id')->references('id')->on('partners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_product');
    }
}
