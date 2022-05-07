<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Image()
 * @method static static Video()
 */
final class CarouselType extends Enum
{
    const Image = 0;
    const Video = 1;
}
