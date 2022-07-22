<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Permission extends Enum
{
    const CTREATE_ADMIN = 'create admin';
    const EDIT_PROFILE = 'edit profile';
    const EDIT_HOTEL = 'edit hotel';

    const INVOICE_ALLOWED = 'invoice allowed';

    /**
     * Get array permission for role
     *
     * @param string $role
     *
     * @return array
     */
    public static function role($role): array
    {
        switch ($role) {
            case UserRole::ADMIN:
                $permissions = [
                    self::CTREATE_ADMIN,
                    self::EDIT_PROFILE,
                    self::EDIT_HOTEL,
                ];
                break;
            default:
                $permissions = [
                    self::CTREATE_ADMIN,
                    self::EDIT_PROFILE,
                    self::EDIT_HOTEL,
                    self::INVOICE_ALLOWED,
                ];
        }

        return $permissions;
    }
}
