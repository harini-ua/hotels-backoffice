<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HotelFacility extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotel_facility';
}
