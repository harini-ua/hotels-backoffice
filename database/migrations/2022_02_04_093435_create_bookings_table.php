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
            $table->string('item_code', 100)->default(null);
            $table->date('checkin');
            $table->date('checkout');
            $table->unsignedBigInteger('hotel_id');
            $table->mediumText('room_type');
            $table->unsignedBigInteger('meal_plan_variant_id');
            $table->smallInteger('rooms');
            $table->smallInteger('nights');
            $table->dateTime('cancellation_date')->default(null);
            $table->boolean('refundable_status')->default(0)->comment('0-non refundable, 1-refundable');
            $table->unsignedBigInteger('booking_status_id');
            $table->unsignedBigInteger('user_id')->default(null);
            $table->unsignedBigInteger('city_id');
            $table->string('inn_off_code')->default(null);
            $table->tinyInteger('adults');
            $table->tinyInteger('children')->default(null);
            $table->text('remarks')->default(null);
            $table->string('customer_email', 100);
            $table->string('customer_phone', 100);
            $table->double('amount', 10, 4)->comment('start booking amount in EUR');
            $table->double('commission', 10, 4)->comment('booking commission in EUR');
            $table->double('final_amount', 10, 4)->comment('final booking amount with commission and discount in EUR');
            $table->unsignedBigInteger('currency_id')->comment('selected currency');
            $table->double('conversion_rate', 8, 6)->comment('conversion rate from EUR to selected currency');
            $table->unsignedBigInteger('discount_voucher_code_id')->default(null);
            $table->double('discount_voucher_conversion_rate', 8, 6)->comment('conversion rate from discount currency to EUR')->default(null);
            $table->double('discount_voucher_amount', 10, 4)->comment('discount amount in EUR')->default(null);
            $table->unsignedBigInteger('booking_payment_type_id');
            $table->string('room_rate_key', 1000)->default(null);
            $table->string('payment_reference', 1000)->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->foreign('meal_plan_variant_id')->references('id')->on('meal_plans_variants');
            $table->foreign('booking_status_id')->references('id')->on('booking_statuses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('discount_voucher_code_id')->references('id')->on('discount_vouchers_codes');
            $table->foreign('booking_payment_type_id')->references('id')->on('booking_payment_types');
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
