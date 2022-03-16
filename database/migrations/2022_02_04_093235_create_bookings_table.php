<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->string('booking_reference', 100);
            $table->string('item_code', 100)->nullable();
            $table->date('checkin');
            $table->date('checkout');
            $table->unsignedBigInteger('hotel_id');
            $table->mediumText('room_type');
            $table->unsignedBigInteger('meal_plan_variant_id');
            $table->smallInteger('rooms');
            $table->smallInteger('nights');
            $table->dateTime('cancellation_date')->nullable();
            $table->boolean('refundable_status')->default(0)->comment('0-non refundable, 1-refundable');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->string('inn_off_code')->nullable();
            $table->tinyInteger('adults');
            $table->tinyInteger('children')->nullable();
            $table->text('remarks')->nullable();
            $table->string('customer_email', 100);
            $table->string('customer_phone', 100);
            $table->double('amount', 10, 4)->comment('start booking amount in EUR');
            $table->double('commission', 10, 4)->comment('booking commission in EUR');
            $table->double('final_amount', 10, 4)->comment('final booking amount with commission and discount in EUR');
            $table->unsignedBigInteger('currency_id')->comment('selected currency');
            $table->double('conversion_rate', 8, 6)->comment('conversion rate from EUR to selected currency');
            $table->unsignedBigInteger('discount_voucher_code_id')->nullable()->unsigned();
            $table->double('discount_voucher_conversion_rate', 8, 6)->nullable()->comment('conversion rate from discount currency to EUR');
            $table->double('discount_voucher_amount', 10, 4)->nullable()->comment('discount amount in EUR');
            $table->string('room_rate_key', 1000)->nullable();
            $table->string('payment_reference', 1000)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->foreign('meal_plan_variant_id')->references('id')->on('meal_plans_variants');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('discount_voucher_code_id')->references('id')->on('discount_voucher_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
