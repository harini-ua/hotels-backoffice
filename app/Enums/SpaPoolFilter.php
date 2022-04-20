<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NoFiltersApplied()
 * @method static static Spa()
 * @method static static SwimmingPool()
 * @method static static SpaOrSwimmingPool()
 * @method static static SpaAndSwimmingPool()
 */
final class SpaPoolFilter extends Enum
{
    const NoFiltersApplied = 0;
    const Spa = 1;
    const SwimmingPool = 2;
    const SpaOrSwimmingPool = 3;
    const SpaAndSwimmingPool = 4;
}
