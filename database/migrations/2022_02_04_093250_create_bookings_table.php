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
            $table->string('booking_reference', 100)->nullable();
            $table->string('booking_cancel_reference', 100)->nullable();
            $table->string('additional_booking_reference', 100)->nullable();
            $table->string('booking_hash', 100)->nullable();
            $table->tinyInteger('payment_type')->comment('0-paid by card, 1-discount, 2-invoice');
            $table->tinyInteger('status')->default(0)->comment('0-not finished, 1-confirmed, 2-cancelled, 3-paid, but not confirmed, 4-not paid');
            $table->string('item_code', 100)->nullable();
            $table->date('checkin');
            $table->date('checkout');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('hotel_id');
            $table->mediumText('room_type');
            $table->smallInteger('rooms');
            $table->smallInteger('nights');
            $table->dateTime('cancellation_date')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->boolean('refundable_status')->default(0)->comment('0-non refundable, 1-refundable');
            $table->unsignedBigInteger('booking_user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('sub_company_id')->nullable();
            $table->string('inn_off_code')->nullable();
            $table->tinyInteger('adults');
            $table->tinyInteger('children')->nullable();
            $table->text('remarks')->nullable();
            $table->string('supplier_name', 200)->nullable();
            $table->string('vat_number', 100)->nullable();
            $table->string('customer_name', 200)->nullable();
            $table->string('customer_email', 100)->nullable();
            $table->string('customer_phone', 100)->nullable();
            $table->double('amount', 10, 4)->comment('start booking amount in EUR');
            $table->double('amount_conversion', 10, 4)->comment('start booking amount in selected currency');
            $table->double('commission', 10, 4)->comment('booking commission in EUR');
            $table->double('final_amount', 10, 4)->comment('final booking amount with commission and discount in EUR');
            $table->double('final_amount_conversion', 10, 4)->comment('final booking amount with commission and discount in selected currency');
            $table->unsignedBigInteger('original_currency_id')->comment('original booking currency');
            $table->unsignedBigInteger('selected_currency_id')->comment('selected currency by user');
            $table->double('conversion_rate', 8, 6)->comment('conversion rate from EUR to selected currency');
            $table->unsignedBigInteger('discount_voucher_code_id')->nullable()->unsigned();
            $table->double('discount_amount', 10, 4)->nullable()->comment('discount amount in EUR');
            $table->string('room_rate_key', 1000)->nullable();
            $table->string('payment_reference', 1000)->nullable();
            $table->double('partner_amount', 10, 4)->nullable()->comment('booking amount on booking with partner price grid');
            $table->unsignedBigInteger('partner_currency_id')->nullable()->comment('booking currency id on booking with partner price grid');
            $table->double('vat', 10, 4)->nullable();
            $table->double('pay_to_client', 10, 4)->nullable()->comment('pay back to client');
            $table->double('sales_office_commission', 10, 4)->nullable()->comment('sales office commission in EUR');
            $table->double('sub_company_commission', 10, 4)->nullable()->comment('sub company commission in EUR');
            $table->tinyInteger('mail_flag')->default(0)->comment('email sending status to user');
            $table->tinyInteger('extra_nights')->default(0)->comment('booking with Extra nights option');

            $table->tinyInteger('platform_type')->default(2)->nullable()
                ->comment('1-mobile app, 2-web browser, 3-mobile browser, 4-mac browser');
            $table->string('platform_version')->nullable()
                ->comment('Platform version info such as browser version, mobile os version etc');
            $table->mediumText('platform_details')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->foreign('booking_user_id')->references('id')->on('booking_users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('sub_company_id')->references('id')->on('sub_companies');
            $table->foreign('original_currency_id')->references('id')->on('currencies');
            $table->foreign('selected_currency_id')->references('id')->on('currencies');
            $table->foreign('partner_currency_id')->references('id')->on('currencies');
            $table->foreign('discount_voucher_code_id')->references('id')->on('discount_voucher_codes');
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
