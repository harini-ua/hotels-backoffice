<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class BookingPlatform extends Enum
{
    const MOBILE_APP = 1;
    const WEB_BROWSER = 2;
    const MOBILE_BROWSER = 3;
    const MAC_BROWSER = 4;
    const IPAD_BROWSER = 5;
    const LINUX_BROWSER = 6;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::MOBILE_APP) {
            return __('Mobile App');
        }
        if ($value === self::WEB_BROWSER) {
            return __('Web Browser');
        }
        if ($value === self::MOBILE_BROWSER) {
            return __('Mobile Browser');
        }
        if ($value === self::MAC_BROWSER) {
            return __('MAC Browser');
        }
        if ($value === self::IPAD_BROWSER) {
            return __('IPAD Browser');
        }
        if ($value === self::LINUX_BROWSER) {
            return __('Linux Browser');
        }

        return parent::getDescription($value);
    }
}
