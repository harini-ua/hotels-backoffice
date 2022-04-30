<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Country()
 * @method static static City()
 * @method static static CompanyBooking()
 * @method static static CompanySale()
 */
final class CommissionType extends Enum
{
    const Country = 1;
    const City = 2;
    const CompanyBooking = 3;
    const CompanySale = 4;
}
