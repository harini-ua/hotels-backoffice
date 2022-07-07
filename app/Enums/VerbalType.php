<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class VerbalType extends Enum
{
    const EXISTING = 0;
    const WEB = 1;
    const MOBILE = 2;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::EXISTING:
            default:
                return __('Existing Verbals');
            case self::WEB:
                return __('Web Verbals');
            case self::MOBILE:
                return __('Mobile Verbals');
        }
    }
}
