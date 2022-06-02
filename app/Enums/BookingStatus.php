<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class BookingStatus extends Enum
{
    const PAYMENT_FAILURE = 0;
    const CONFIRMED = 1;
    const CANCELLED = 2;
    const PAID_BUT_NOT_CONFIRMED = 3;
    const NOT_PAID = 4;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::PAYMENT_FAILURE) {
            return __('Payment Failure');
        }
        if ($value === self::CONFIRMED) {
            return __('Confirmed');
        }
        if ($value === self::CANCELLED) {
            return __('Cancelled');
        }
        if ($value === self::PAID_BUT_NOT_CONFIRMED) {
            return __('Paid, But Not Confirmed');
        }
        if ($value === self::NOT_PAID) {
            return __('Not Paid');
        }

        return parent::getDescription($value);
    }
}
