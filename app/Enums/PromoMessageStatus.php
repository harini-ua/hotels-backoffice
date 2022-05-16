<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Active()
 * @method static static Inactive()
 */
final class PromoMessageStatus extends Enum
{
    const Active = 0;
    const Inactive = 1;
}
