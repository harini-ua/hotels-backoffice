<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ADMIN()
 * @method static static DISTRIBUTOR()
 * @method static static EMPLOYEE()
 * @method static static BOOKING()
 */
final class UserRole extends Enum
{
    const ADMIN = 'admin';
    const DISTRIBUTOR = 'distributor';
    const EMPLOYEE = 'employee';
    const BOOKING = 'booking';
}
