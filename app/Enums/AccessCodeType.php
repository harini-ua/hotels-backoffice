<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AccessCodeType extends Enum
{
    const UNIQUE = 0;
    const FIXED = 1;
    const NO_CODE = 2;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::NO_CODE) {
            return __('No registration code required');
        }
        if ($value === self::UNIQUE) {
            return __('Multiple codes');
        }
        if ($value === self::FIXED) {
            return __('One code (Fixed)');
        }

        return parent::getDescription($value);
    }
}
