<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HotelProvider extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotel_provider';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_hotel_code', 'tti_code', 'giata_code', 'status', 'blacklisted', 'hotel_name',
    ];
}
