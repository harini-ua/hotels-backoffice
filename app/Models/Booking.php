<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'bookings';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id', 'booking_reference', 'booking_cancel_reference', 'booking_hash', 'payment_type', 'status',
        'item_code', 'checkin', 'checkout', 'country_id', 'city_id', 'hotel_id', 'room_type', 'rooms', 'nights',
        'cancellation_date', 'cancelled_date', 'cancellation_policy', 'refundable_status', 'bookind_user_id',
        'company_id', 'sub_company_id', 'inn_off_code', 'adults', 'children', 'remarks', 'customer_name',
        'customer_email', 'customer_phone', 'amount', 'amount_conversion', 'commission', 'final_amount',
        'final_amount_conversion', 'original_currency_id', 'selected_currency_id', 'conversion_rate',
        'discount_voucher_code_id', 'discount_amount', 'room_rate_key', 'payment_reference', 'partner_amount',
        'partner_currency_id', 'vat', 'pay_to_client', 'sales_office_commission', 'mail_flag', 'extra_nights',
        'platform_type', 'platform_version', 'platform_details', 'additional_booking_reference', 'supplier_name',
        'vat_number',
    ];

    /**
     * Get the company that owns the booking.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

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
     * Get the selected currency that owns the booking.
     */
    public function selected_currency()
    {
        return $this->belongsTo(Currency::class, 'selected_currency_id');
    }

    /**
     * Get the original currency that owns the booking.
     */
    public function original_currency()
    {
        return $this->belongsTo(Currency::class, 'original_currency_id');
    }

    /**
     * Get the partner currency that owns the booking.
     */
    public function partner_currency()
    {
        return $this->belongsTo(Currency::class, 'partner_currency_id');
    }

    /**
     * Get the discount code that owns the booking.
     */
    public function discountCode()
    {
        return $this->belongsTo(DiscountVoucherCode::class);
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

    public function companySaleOfficeCommissions()
    {
        return $this->hasMany(CompanySaleOfficeCommission::class, 'company_id', 'company_id');
    }

    /**
     * Get the distributor booking commission for the booking.
     */
    public function distributorBookingCommission()
    {
        return $this->hasMany(DistributorBookingCommission::class);
    }

    /**
     * Get the distributor booking commission for the booking by conditions.
     */
    public function distributorBookingCommissionByConditions($company_id, $level)
    {
        return $this->distributorBookingCommission()
            ->where('company_id', $company_id)
            ->where('level', $level);
    }
}
