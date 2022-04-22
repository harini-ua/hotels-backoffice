<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMainOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_main_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
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
            $table->boolean('chat_enabled')->default(0);
            $table->text('chat_script');
            $table->boolean('adobe_enabled')->default(0);
            $table->text('adobe_script');
            $table->json('hotel_distances_filter');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('price_filter_currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * @throws JsonException
     */
    protected function getDefaultHotelDistances()
    {
        $filters = [
            'dist_bars_pubs',
            'dist_beach',
            'dist_bus_station',
            'dist_city_centre',
            'dist_cross_country_skiing',
            'dist_forest',
            'dist_golf_course',
            'dist_lake',
            'dist_nightclubs',
            'dist_park',
            'dist_public_transport',
            'dist_restaurants',
            'dist_river',
            'dist_sea',
            'dist_shopping',
            'dist_ski_area',
            'dist_ski_lift',
            'dist_station',
            'dist_tourist_centre',
            'dist_train_station',
        ];

        $default = [];
        foreach ($filters as $filter)
        {
            $default[] = [
                "name" => $filter,
                "value" => "",
                "status" => 1
            ];
        }

        return json_encode($default, JSON_THROW_ON_ERROR);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_main_options');
    }
}
