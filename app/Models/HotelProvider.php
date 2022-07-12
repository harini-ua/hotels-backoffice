<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HotelProvider extends Pivot
{
    public const TABLE_NAME = 'hotel_provider';

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
        'provider_hotel_code', 'tti_code', 'giata_code', 'status', 'blacklisted', 'hotel_name',
    ];
}
