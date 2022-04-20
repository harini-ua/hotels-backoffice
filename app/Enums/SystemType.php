<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CompanySite()
 * @method static static GoDreamSystem()
 * @method static static WonderBoxSystem()
 */
final class SystemType extends Enum
{
    const CompanySite = 0;
    const GoDreamSystem = 1;
    const WonderBoxSystem = 2;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::CompanySite) {
            return __('Company Site');
        }
        if ($value === self::GoDreamSystem) {
            return __('GoDream System');
        }
        if ($value === self::WonderBoxSystem) {
            return __('WonderBox System');
        }

        return parent::getDescription($value);
    }
}
