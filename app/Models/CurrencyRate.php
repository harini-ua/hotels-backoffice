<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'country_currency_rates';

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
        'country_id', 'currency_id', 'rates'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rates' => 'object',
    ];

    /**
     * Get the country for the currency rate.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the currency that owns the currency rate.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
