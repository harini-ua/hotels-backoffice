<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DiscountCommissionType extends Enum
{
    const NoCommission = 0;
    const CompanySiteDistributorHQ = 1;
    const CompanySite = 2;
    const DistributorHQ = 3;
    const Distributor = 4;
    const HqAllProfitDistributorRemaining = 5;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::NoCommission) {
            return __('No commission deducted');
        }
        if ($value === self::CompanySiteDistributorHQ) {
            return __('White label, distributor and HQ');
        }
        if ($value === self::CompanySite) {
            return __('White label only');
        }
        if ($value === self::DistributorHQ) {
            return __('Distributor and HQ only');
        }
        if ($value === self::Distributor) {
            return __('Distributor only');
        }
        if ($value === self::HqAllProfitDistributorRemaining) {
            return __('HQ all profit and Distributor remaining');
        }

        return parent::getDescription($value);
    }
}
