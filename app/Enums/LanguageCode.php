<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LanguageCode extends Enum
{
    const EN = 'en';
    const UK = 'uk';
    const KO = 'ko';
    const EL = 'el';
    const KA = 'ka';
    const DA = 'da';
    const ZH = 'zh';

    /**
     * Get the color values for an status
     *
     * @param string $code
     * @param string $value
     *
     * @return string
     */
    public static function getFlagCode(string $code): string
    {
        $flagCode = $code;
        switch ($code) {
            case self::EN:
                $flagCode = 'gb';
                break;
            case self::UK:
                $flagCode = 'ua';
                break;
            case self::KO:
                $flagCode = 'kr';
                break;
            case self::EL:
                $flagCode = 'gr';
                break;
            case self::KA:
                $flagCode = 'ge';
                break;
            case self::DA:
                $flagCode = 'dk';
                break;
            case self::ZH:
                $flagCode = 'cn';
                break;
        }

        return $flagCode;
    }
}
