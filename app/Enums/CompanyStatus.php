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

    /**
     * Get the color values for an status
     *
     * @param string $status
     * @param string $value
     *
     * @return string
     */
    public static function getColor(string $status, string $value = 'hash'): string
    {
        switch ($status) {
            case self::Active:
                $values = ['success', '#43d187'];
                break;
            case self::InActive:
                $values = ['danger', '#f9616d'];
                break;
            case self::InProgress:
            default:
                $values = ['warning', '#f7bb4d'];
                break;
        }

        $values = array_combine(['class', 'hash'], $values);

        return $values[$value];
    }
}
