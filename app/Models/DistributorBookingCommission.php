<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorBookingCommission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'distributor_booking_commission';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'booking_id', 'country_id', 'commission', 'level', 'company_commission', 'company_standard'
    ];

    /**
     * Get the company that owns the distributor booking commission.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the booking that owns the distributor booking commission.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the country that owns the distributor booking commission.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
