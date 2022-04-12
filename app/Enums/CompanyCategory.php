<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CompanyClient()
 * @method static static Distributor()
 */
final class CompanyCategory extends Enum
{
    const CompanyClient = 0;
    const Distributor = 1;
}
