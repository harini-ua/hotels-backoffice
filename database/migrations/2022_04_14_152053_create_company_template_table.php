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
            $table->unsignedBigInteger('meal_plan_id');
            $table->tinyInteger('spa_pool_filter');
            $table->tinyInteger('system');
            $table->unsignedBigInteger('language_id');

            $table->boolean('vat')->nullable();
            $table->boolean('price_guarantee')->nullable();
            $table->boolean('show_car_rental_tab')->nullable();
            $table->boolean('show_extra_benefit_tab')->nullable();
            $table->boolean('show_hotel_tab')->nullable();
            $table->boolean('show_flight_tab')->nullable();
            $table->boolean('default_newsletter')->nullable();
            $table->boolean('popular_sorting')->nullable();
            $table->boolean('signup_flag')->nullable();
            $table->boolean('login_flag')->nullable();
            $table->boolean('enable_star_rating')->nullable();
            $table->boolean('min_star_rating')->nullable();
            $table->boolean('max_star_rating')->nullable();
            $table->boolean('chat_enabled')->nullable();
            $table->boolean('voucher_search')->nullable();
            $table->boolean('secure_payment')->nullable();
            $table->boolean('new_user_secure_payment')->nullable();
            $table->boolean('restel_non_refundable')->nullable();
            $table->boolean('show_resort_tab')->nullable();
            $table->boolean('invoice_enabled')->nullable();
            $table->boolean('user_state')->nullable();
            $table->boolean('allow_package')->nullable();
            $table->boolean('show_mobile_store_links')->nullable();
            $table->boolean('show_number_hotels')->nullable();
            $table->boolean('show_all_booking_non_refund')->nullable();

            $table->timestamps();

            $table->foreign('meal_plan_id')->references('id')->on('meal_plans');
            $table->foreign('language_id')->references('id')->on('languages');
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
