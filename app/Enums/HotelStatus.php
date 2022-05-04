<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static New()
 * @method static static Updated()
 * @method static static Old()
 * @method static static Deleted()
 */
final class HotelStatus extends Enum
{
    const New = 1;
    const Updated = 2;
    const Old = 3;
    const Deleted = 4;
}
