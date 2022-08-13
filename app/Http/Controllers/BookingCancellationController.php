<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingCancellationController extends Controller
{
    /**
     * @param string $hash
     * @return bool
     */
    public function __invoke($hash)
    {
        $booking = Booking::where('booking_hash', $hash)->first();

        if ($booking) {
            return false;
        }

        // TODO: Need Implement

        return false;
    }
}
