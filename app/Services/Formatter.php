<?php

namespace App\Services;

use Carbon\Carbon;

class Formatter
{
    /**
     * @param string $value
     * @param string|null $symbol
     * @param bool $html
     *
     * @return string
     */
    public static function currency($value, $symbol = null, $html = false): string
    {
        $currency_format = config('admin.currency.format');
        $delimiter = config('admin.currency.delimiter');
        $value = number_format($value, ...array_values(config('admin.number.format')));

        return strtr($currency_format, [
            '{SYMBOL}' => $html ? '<span class="symbol">' . $symbol . '</span>' : $symbol,
            '{DELIMITER}' => $symbol ? $delimiter : null,
            '{VALUE}' => $html ? '<span class="value">' . $value . '</span>' : $value,
        ]);
    }

    /**
     * @param string $value
     * @param string|null $format
     *
     * @return string
     */
    public static function date($value, $format = null): string
    {
        return Carbon::parse($value)->format($format ?? config('admin.date.format'));
    }
}
