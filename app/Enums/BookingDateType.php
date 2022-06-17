<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BookingDateType extends Enum
{
    const CONFIRMATION = 0;
    const CHECK = 1;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::CONFIRMATION) {
            return __('Confirmation / Voucher Date');
        }
        if ($value === self::CHECK) {
            return __('Check In / Check Out');
        }

        return parent::getDescription($value);
    }
}
