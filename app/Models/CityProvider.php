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
        'provider_city_code',
    ];
}
