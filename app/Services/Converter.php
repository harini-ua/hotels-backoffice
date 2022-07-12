<?php

namespace App\Services;

use App\Models\CountryCurrencyRate;
use App\Models\Currency;

class Converter
{
    /**
     * @param string $value
     * @param $oldCurrency
     * @param $newCurrency
     * @return mixed
     */
    public static function price(string $value, $oldCurrency, $newCurrency): mixed
    {
        $oldCurrency = Currency::where('code', $oldCurrency)->first();

        $rate = \DB::table(CountryCurrencyRate::TABLE_NAME)
            ->select(
                \DB::raw('json_extract(rates, "$.'.$newCurrency.'") AS value')
            )
            ->where('currency_id', $oldCurrency->id)
            ->first()
            ->value;

        return round($rate / 1000 * $value, 2);
    }
}
