<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentType extends Enum
{
    const CARD = 0;
    const DISCOUNT = 1;
    const INVOICE = 2;
}
