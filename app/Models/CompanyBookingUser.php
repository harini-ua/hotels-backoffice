<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyBookingUser extends Pivot
{
    public const TABLE_NAME = 'company_booking_user';

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
        'company_id', 'booking_user_id'
    ];

    /**
     * Get the company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the booking user.
     */
    public function bookingUsers()
    {
        return $this->belongsTo(BookingUser::class);
    }
}
