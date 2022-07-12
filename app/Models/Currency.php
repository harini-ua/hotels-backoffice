<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Currency extends Model
{
    use HasFactory, QueryCacheable;

    public const TABLE_NAME = 'currencies';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @var int
     */
    protected $cacheFor = 84400; // 1 day

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
