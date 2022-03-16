<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CountryCommission extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country_commission';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commission',
    ];
}
