<?php

namespace App\Classes\Bookings;

use function config;

abstract class BookingAbstract implements BookingInterface
{
    /** @var array */
    protected $config;

    public function __construct()
    {
        $this->config = config('booking');
    }
}
