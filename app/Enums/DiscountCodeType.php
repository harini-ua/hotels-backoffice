<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Individual()
 * @method static static AccessForAll()
 */
final class DiscountCodeType extends Enum
{
    const Individual = 0;
    const AccessForAll = 1;
}
