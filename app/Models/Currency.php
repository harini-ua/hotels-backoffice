<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
    ];

    /**
     * Get the countries for the currency.
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    /**
     * Get the user for the currency.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the discount for the currency.
     */
    public function discount()
    {
        return $this->hasMany(DiscountVoucher::class);
    }

    /**
     * Get the bookings for the currency.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
