<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedBigInteger('meal_plan_id');
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->double('price', 8, 2)->default(0);
            $table->double('partner_pay_price', 8, 2)->default(0);
            $table->mediumInteger('partner_commission')->default(0);
            $table->boolean('price_filter')->default(0);
            $table->double('price_min', 8, 2)->default(0);
            $table->double('price_max', 8, 2)->default(0);
            $table->boolean('star_filter')->default(0);
            $table->smallInteger('star_min')->default(1);
            $table->smallInteger('star_max')->default(5);
            $table->double('commission_min', 8, 2);
            $table->smallInteger('nights')->default(2);
            $table->smallInteger('adults')->default(2);
            $table->boolean('sold_online')->default(0);
            $table->boolean('sold_retail')->default(0);
            $table->string('sku')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('include_nrf')->default(0);
            $table->boolean('show_all_as_nrf')->default(0);
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
        Schema::dropIfExists('partner_products');
    }
}
