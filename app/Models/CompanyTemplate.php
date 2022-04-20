<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTemplate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_template';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'client_level', 'meal_plan_id', 'spa_pool_filter', 'system', 'language_id',
        'vat', 'price_guarantee', 'show_car_rental_tab', 'show_extra_benefit_tab', 'show_hotel_tab', 'show_flight_tab',
        'default_newsletter', 'popular_sorting', 'signup_flag', 'login_flag', 'enable_star_rating', 'min_star_rating',
        'max_star_rating', 'chat_enabled', 'voucher_search', 'secure_payment', 'new_user_secure_payment',
        'restal_non_refundable', 'show_resort_tab', 'invoice_enabled', 'user_state', 'allow_package',
        'show_mobile_store_links', 'show_number_hotels', 'show_all_booking_non_refund',
    ];

    /**
     * Get all boolean fields
     *
     * @return string[]
     */
    public static function getBooleanFoields()
    {
        return [
            'vat' => 'VAT',
            'price_guarantee' => 'Price Guarantee',
            'show_car_rental_tab' => 'Show Car Rental Tab',
            'show_extra_benefit_tab' => 'Show Extra Benefit Tab',
            'show_hotel_tab' => 'Show Hotel Tab',
            'show_flight_tab' => 'Show Flight Tab',
            'default_newsletter' => 'Default Newsletter',
            'popular_sorting' => 'Popular Sorting',
            'signup_flag' => 'Signup Flag',
            'login_flag' => 'Login Flag',
            'enable_star_rating' => 'Enable Star Rating',
            'min_star_rating' => 'Min Star Rating',
            'max_star_rating' => 'Max Star Rating',
            'chat_enabled' => 'Chat Enabled',
            'voucher_search' => 'Voucher Search',
            'secure_payment' => 'Secure Payment',
            'new_user_secure_payment' => 'New User Secure Payment',
            'restal_non_refundable' => 'Restal Non Refundable',
            'show_resort_tab' => 'Show Resort Tab',
            'invoice_enabled' => 'Invoice Enabled',
            'user_state' => 'User State',
            'allow_package' => 'Allow Package',
            'show_mobile_store_links' => 'Show Mobile Store Links',
            'show_number_hotels' => 'Show Number Hotels',
            'show_all_booking_non_refund' => 'Show All Booking Non Refund',
        ];
    }

    /**
     * Get the meal plan that owns the company template.
     */
    public function mealPlan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MealPlan::class);
    }

    /**
     * Get the language that owns the company template.
     */
    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
