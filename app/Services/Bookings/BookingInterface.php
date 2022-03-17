<?php

namespace App\Services\Bookings;

interface BookingInterface
{
    /**
     * Create booking
     *
     * @return mixed
     */
    public function create();

    /**
     * Confirmation booking
     *
     * @return mixed
     */
    public function confirm();

    /**
     * Cancel booking
     *
     * @return mixed
     */
    public function cancel();
}
