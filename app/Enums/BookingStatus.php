<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class BookingStatus extends Enum
{
    const CANCELLED = 0;
    const CONFIRMED = 1;
    const PAID_BUT_NOT_CONFIRMED = 2;
    const NOT_PAID = 3;
    const PAYMENT_FAILURE = 2;
}
