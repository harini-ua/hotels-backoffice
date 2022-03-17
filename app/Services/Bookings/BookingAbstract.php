<?php

namespace App\Services\Bookings;

abstract class BookingAbstract implements BookingInterface
{
    /** @var array */
    protected $config;

    public function __construct()
    {
        $this->config = config('booking');
    }
}
