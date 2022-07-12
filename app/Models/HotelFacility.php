<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HotelFacility extends Pivot
{
    public const TABLE_NAME = 'hotel_facility';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;
}
