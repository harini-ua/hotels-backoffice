<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyMainOption extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_main_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'show_price_guarantee', 'show_car_rental_tab', 'show_extra_benefit_tab', 'show_hotel_tab',
        'show_flight_tab', 'show_resort_tab', 'show_nearby_hotels', 'show_popular_hotels', 'show_number_of_hotels',
        'show_mobile_store_links', 'show_popular_sorting', 'show_sightseeing', 'use_redirect', 'show_price_filter',
        'price_filter_currency_id', 'min_price_filter', 'max_price_filter', 'show_star_rating', 'min_star_rating',
        'max_star_rating', 'ask_voucher_on_search', 'use_secure_payment', 'show_restel_non_refundable',
        'show_all_rooms_non_refundable', 'invoice_payment', 'allow_package', 'spa_pool_filter', 'chat_enabled',
        'chat_script', 'adobe_enabled', 'adobe_script',
    ];

    /**
     * Get the company that owns the company homepage option.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the price filter currency that owns the company homepage option.
     */
    public function priceFilter()
    {
        return $this->belongsTo(Currency::class);
    }
}
