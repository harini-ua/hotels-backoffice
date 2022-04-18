<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static All()
 * @method static static CompanySiteClients()
 * @method static static BookingUsers()
 */
final class NewsletterUserType extends Enum
{
    const All = 0;
    const CompanySiteClient = 1;
    const BookingUsers = 2;
}
