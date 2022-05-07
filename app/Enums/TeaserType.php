<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Default()
 * @method static static Testimonial()
 */
final class TeaserType extends Enum
{
    const Default = 0;
    const Testimonial = 1;
}
