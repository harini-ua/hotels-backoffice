<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('holder_name');
            $table->string('company_name');
            $table->boolean('category');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->text('address');
            $table->string('email')->unique();
            $table->string('phone');
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active, 2-pending');
            $table->binary('logo');
            $table->tinyInteger('level')->default(1)->comment('0-without level, 1-fist level, 2-second level');
            $table->boolean('vat')->default(0);
            $table->boolean('newsletter')->default(0);
            $table->boolean('show_price_guarantee')->default(1);
            $table->boolean('show_car_rental_tab')->default(1);
            $table->boolean('show_extra_benefit_tab')->default(1);
            $table->boolean('show_hotel_tab')->default(1);
            $table->boolean('show_flight_tab')->default(1);
            $table->boolean('show_resort_tab')->default(0);
            $table->boolean('show_nearby_hotels')->default(1);
            $table->boolean('show_popular_hotels')->default(1);
            $table->boolean('show_number_of_hotels')->default(1);
            $table->boolean('show_mobile_store_links')->default(0);
            $table->boolean('show_popular_sorting')->default(0);
            $table->boolean('show_sightseeing')->default(1);
            $table->boolean('use_redirect')->default(0);
            $table->unsignedBigInteger('theme_id');
            $table->boolean('show_price_filter')->default(0);
            $table->unsignedBigInteger('price_filter_currency_id');
            $table->double('min_price_filter', 8, 2);
            $table->double('max_price_filter', 8, 2);
            $table->boolean('show_star_rating')->default(0);
            $table->smallInteger('min_star_rating');
            $table->smallInteger('max_star_rating');
            $table->boolean('ask_voucher_on_search')->default(0);
            $table->boolean('use_secure_payment')->default(1);
            $table->boolean('show_restel_non_refundable')->default(1);
            $table->boolean('show_all_rooms_non_refundable')->default(0);
            $table->boolean('invoice_payment')->default(0);
            $table->boolean('allow_package')->default(0);
            $table->tinyInteger('spa_pool_filter')->default(0)->comment('0 - no filter; 1 - spa; 2 - swimming pool; 3 - spa OR pool; 4 - spa AND pool');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('email', 'unique_email');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('theme_id')->references('id')->on('company_theme');
            $table->foreign('price_filter_currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
