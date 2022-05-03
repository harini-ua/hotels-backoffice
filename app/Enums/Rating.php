<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ONE()
 * @method static static TWO()
 * @method static static THREE()
 * @method static static FOUR()
 * @method static static FIVE()
 */
final class Rating extends Enum
{
    const ONE = 1;
    const TWO = 2;
    const THREE = 3;
    const FOUR = 4;
    const FIVE = 5;
}
