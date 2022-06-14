<?php

namespace App\Services;

use App\Models\Currency;

class Converter
{
    /**
     * @param string $value
     * @param $oldCurrency
     * @param $newCurrency
     * @return string
     */
    public static function price(string $value, $oldCurrency, $newCurrency): string
    {
        $oldCurrency = Currency::whereCode($oldCurrency)->first();

        $rates = \DB::table('country_currency_rates')
            ->select('rates->'.$newCurrency)
            ->where('currency_id', $oldCurrency->code)
            ->get();
    }
}
