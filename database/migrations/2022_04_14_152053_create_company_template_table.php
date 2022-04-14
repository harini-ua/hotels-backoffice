<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_template', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_level');
            $table->string('meal_plan_id');
            $table->string('spa_pool_filter');
            $table->tinyInteger('system');

            $table->boolean('vat');
            $table->boolean('price_guarantee');
            $table->boolean('show_car_rental_tab');
            $table->boolean('show_extra_benefit_tab');
            $table->boolean('show_hotel_tab');
            $table->boolean('show_flight_tab');
            $table->boolean('default_newsletter');
            $table->boolean('popular_sorting');
            $table->boolean('signup_flag');
            $table->boolean('login_flag');
            $table->boolean('enable_star_rating');
            $table->boolean('min_star_rating');
            $table->boolean('max_star_rating');
            $table->boolean('chat_enabled');
            $table->boolean('voucher_search');
            $table->boolean('secure_payment');
            $table->boolean('new_user_secure_payment');
            $table->boolean('restal_non_refundable');
            $table->boolean('show_resort_tab');
            $table->boolean('invoice_enabled');
            $table->boolean('user_state');
            $table->boolean('allow_package');
            $table->boolean('show_mobile_store_links');
            $table->boolean('show_number_hotels');
            $table->boolean('show_all_booking_non_refund');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_template');
    }
}
