<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CityProvider extends Pivot
{
    public const TABLE_NAME = 'city_provider';

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
        'city_id', 'provider_id', 'provider_city_code', 'status', 'active'
    ];

    /**
     * Get the city that owns the city provider.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the provider that owns the city provider.
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
