<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Fixed()
 * @method static static Percent()
 */
final class DiscountAmountType extends Enum
{
    const Fixed = 0;
    const Percent = 1;
}
