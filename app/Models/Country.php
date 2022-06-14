<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency_id', 'language_id', 'name', 'region', 'code', 'active', 'blacklisted', 'commission'
    ];

    /**
     * Get the currency that owns the country.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the currency rate that owns the country.
     */
    public function currencyRate()
    {
        return $this->belongsTo(CurrencyRate::class);
    }

    /**
     * Get the language that owns the country.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the cities for the country.
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * The commissions that belong to the country.
     */
    public function commissions()
    {
        return $this
            ->belongsToMany(Commission::class, (new CountryCommission())->getTable())
            ->using(CountryCommission::class)
            ->withPivot((new CountryCommission())->getFillable());
    }

    /**
     * The distributors that belong to the country.
     */
    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_country');
    }

    /**
     * Get the user for the country.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
