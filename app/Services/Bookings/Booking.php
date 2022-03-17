<?php

namespace App\Services\Bookings;

use Psr\Log\InvalidArgumentException;

final class Booking
{
    /**
     * @param string $type
     * @return BookingInterface
     */
    public static function init(string $type): BookingInterface
    {
        if (class_exists($type)) {
            return new $type();
        }

        throw (new InvalidArgumentException(__('Unknown booking given')));
    }
}
