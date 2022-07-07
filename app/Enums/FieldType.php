<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class FieldType extends Enum
{
    const TEXT = 0;
    const TEXTAREA = 1;
    const BUTTON = 2;
    const HTML = 3;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::TEXT:
            default:
                return __('Text Field');
            case self::TEXTAREA:
                return __('Text Area');
            case self::BUTTON:
                return __('Button');
            case self::HTML:
                return __('HTML Content');
        }
    }
}
