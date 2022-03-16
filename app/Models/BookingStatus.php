<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;

    /**
     * Get the booking that owns the booking guest.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
