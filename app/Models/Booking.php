<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id', 'booking_reference', 'item_code', 'checkin', 'checkout', 'hotel_id', 'room_type',
        'meal_plan_variant_id', 'rooms', 'nights', 'cancellation_date', 'refundable_status', 'user_id', 'city_id',
        'inn_off_code', 'adults', 'children', 'remarks', 'customer_email', 'customer_phone', 'amount', 'commission',
        'final_amount', 'currency_id', 'conversion_rate', 'discount_voucher_code_id',
        'discount_voucher_conversion_rate', 'discount_voucher_amount', 'booking_payment_type_id', 'room_rate_key',
        'payment_reference',
    ];

    /**
     * Get the provider that owns the booking.
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Get the country that owns the booking.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the booking.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the hotel that owns the booking.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the booking user that owns the booking.
     */
    public function bookingUser()
    {
        return $this->belongsTo(BookingUser::class);
    }

    /**
     * Get the currency that owns the booking.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the discount code that owns the booking.
     */
    public function discountCode()
    {
        return $this->belongsTo(DiscountVoucherCode::class);
    }

    /**
     * Get the meal plan variant that owns the booking.
     */
    public function mealPlanVariant()
    {
        return $this->belongsTo(MealPlanVariant::class);
    }

    /**
     * Get the booking guests for the booking.
     */
    public function guests()
    {
        return $this->hasMany(BookingGuest::class);
    }

    /**
     * Get the booking statuses for the booking.
     */
    public function statuses()
    {
        return $this->hasMany(BookingStatus::class);
    }

    /**
     * Get the payment for the booking.
     */
    public function paymentTypes()
    {
        return $this->hasMany(BookingPaymentType::class);
    }
}
