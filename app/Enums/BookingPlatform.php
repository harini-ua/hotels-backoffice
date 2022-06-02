<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class BookingSource extends Enum
{
    const MOBILE_APP = 1;
    const WEB_BROWSER = 2;
    const MOBILE_BROWSER = 3;
    const MAC_BROWSER = 4;
    const IPAD_BROWSER = 5;
    const LINUX_BROWSER = 6;
}
