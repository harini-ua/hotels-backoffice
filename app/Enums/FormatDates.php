<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Carbon\Carbon;

/**
 * @method static static EU()
 * @method static static US()
 */
final class FormatDates extends Enum
{
    const EU = 1;
    const US = 2;

    const FORMAT = [
        self::EU => 'j M, Y',
        self::US => 'M j, Y',
    ];

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::EU) {
            $date = Carbon::now()->format('j M, Y');
            return "EU - $date";
        }

        if ($value === self::US) {
            $date = Carbon::now()->format('M j, Y');
            return "US - $date";
        }

        return parent::getDescription($value);
    }
}
