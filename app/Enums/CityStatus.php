<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Active()
 * @method static static InActive()
 */
final class CityStatus extends Enum
{
    const InActive = 0;
    const Active = 1;

    /**
     * Get the color values for an status
     *
     * @param string $status
     * @param string $value
     *
     * @return string
     */
    public static function getColor(string $status, string $value = 'hash'): string
    {
        switch ($status) {
            case self::Active:
                $values = ['success', '#43d187'];
                break;
            case self::InActive:
                $values = ['danger', '#f9616d'];
                break;
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }
}
