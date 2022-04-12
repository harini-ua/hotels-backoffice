<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static InActive()
 * @method static static Active()
 * @method static static InProgress()
 */
final class CompanyStatus extends Enum
{
    const InActive = 0;
    const Active = 1;
    const InProgress = 2;
}
