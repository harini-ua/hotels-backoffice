<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CityProvider extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city_provider';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_city_code',
    ];
}
