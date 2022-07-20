<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static BLACK()
 * @method static static WHITE()
 */
final class IpFilterType extends Enum
{
    const BLACK = 0;
    const WHITE = 1;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::BLACK) {
            return __('Blacklist');
        }

        if ($value === self::WHITE) {
            return __('Whitelist');
        }

        return parent::getDescription($value);
    }

    /**
     * Get the color values for an status
     *
     * @param null|string $type
     * @param string $value
     *
     * @return string
     */
    public static function getColor(string $type, string $value = 'hash'): string
    {
        switch ($type) {
            case self::BLACK:
                $values = ['danger', '#f9616d'];
                break;
            case self::WHITE:
                $values = ['success', '#43d187'];
                break;
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }
}
