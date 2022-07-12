<?php

namespace Database\Seeders;

use App\Models\CountryCurrencyRate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCurrencyRateSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        //FOR country_currency_rates.csv
        //SELECT c.country_id, cn.id, c.updated,
        // CONCAT('INR=', c.C_INR), CONCAT('AED=', c.C_AED), CONCAT('XCD=', c.C_XCD), CONCAT('ALL=', c.C_ALL),
        //CONCAT('ANG=', c.C_ANG), CONCAT('ARS=', c.C_ARS), CONCAT('AUD=', c.C_AUD), CONCAT('EUR=', c.C_EUR),
        //CONCAT('BGN=', c.C_BGN), CONCAT('AWG=', c.C_AWG), CONCAT('BBD=', c.C_BBD), CONCAT('BHD=', c.C_BHD),
        //CONCAT('XOF=', c.C_XOF), CONCAT('BMD=', c.C_BMD), CONCAT('BND=', c.C_BND), CONCAT('BOB=', c.C_BOB),
        //CONCAT('BRL=', c.C_BRL), CONCAT('BSD=', c.C_BSD), CONCAT('BWP=', c.C_BWP), CONCAT('BYR=', c.C_BYR),
        //CONCAT('CAD=', c.C_CAD), CONCAT('CHF=', c.C_CHF), CONCAT('NZD=', c.C_NZD), CONCAT('CLP=', c.C_CLP),
        //CONCAT('CNY=', c.C_CNY), CONCAT('COP=', c.C_COP), CONCAT('CRC=', c.C_CRC), CONCAT('CUP=', c.C_CUP),
        //CONCAT('CZK=', c.C_CZK), CONCAT('DKK=', c.C_DKK), CONCAT('DOP=', c.C_DOP), CONCAT('DZD=', c.C_DZD),
        //CONCAT('USD=', c.C_USD), CONCAT('EGP=', c.C_EGP), CONCAT('ETB=', c.C_ETB), CONCAT('FJD=', c.C_FJD),
        //CONCAT('GBP=', c.C_GBP), CONCAT('GIP=', c.C_GIP), CONCAT('GTQ=', c.C_GTQ), CONCAT('HKD=', c.C_HKD),
        //CONCAT('HNL=', c.C_HNL), CONCAT('HRK=', c.C_HRK), CONCAT('HUF=', c.C_HUF), CONCAT('IDR=', c.C_IDR),
        //CONCAT('ILS=', c.C_ILS), CONCAT('IRR=', c.C_IRR), CONCAT('ISK=', c.C_ISK), CONCAT('JMD=', c.C_JMD),
        //CONCAT('JOD=', c.C_JOD), CONCAT('JPY=', c.C_JPY), CONCAT('KES=', c.C_KES), CONCAT('KHR=', c.C_KHR),
        //CONCAT('KWD=', c.C_KWD), CONCAT('KZT=', c.C_KZT), CONCAT('LBP=', c.C_LBP), CONCAT('LKR=', c.C_LKR),
        //CONCAT('LTL=', c.C_LTL), CONCAT('LVL=', c.C_LVL), CONCAT('LYD=', c.C_LYD), CONCAT('MAD=', c.C_MAD),
        //CONCAT('MDL=', c.C_MDL), CONCAT('MKD=', c.C_MKD), CONCAT('MMK=', c.C_MMK), CONCAT('MNT=', c.C_MNT),
        //CONCAT('MOP=', c.C_MOP), CONCAT('MUR=', c.C_MUR), CONCAT('MVR=', c.C_MVR), CONCAT('MXN=', c.C_MXN),
        //CONCAT('MYR=', c.C_MYR), CONCAT('NAD=', c.C_NAD), CONCAT('XPF=', c.C_XPF), CONCAT('NGN=', c.C_NGN),
        //CONCAT('NIO=', c.C_NIO), CONCAT('NOK=', c.C_NOK), CONCAT('NPR=', c.C_NPR), CONCAT('OMR=', c.C_OMR),
        //CONCAT('PAB=', c.C_PAB), CONCAT('PEN=', c.C_PEN), CONCAT('PHP=', c.C_PHP), CONCAT('PKR=', c.C_PKR),
        //CONCAT('PLN=', c.C_PLN), CONCAT('PYG=', c.C_PYG), CONCAT('QAR=', c.C_QAR), CONCAT('RON=', c.C_RON),
        //CONCAT('RSD=', c.C_RSD), CONCAT('SAR=', c.C_SAR), CONCAT('SCR=', c.C_SCR), CONCAT('SEK=', c.C_SEK),
        //CONCAT('SGD=', c.C_SGD), CONCAT('SZL=', c.C_SZL), CONCAT('THB=', c.C_THB), CONCAT('TND=', c.C_TND),
        //CONCAT('TOP=', c.C_TOP), CONCAT('TRY=', c.C_TRY), CONCAT('TTD=', c.C_TTD), CONCAT('UAH=', c.C_UAH),
        //CONCAT('UGX=', c.C_UGX), CONCAT('UYU=', c.C_UYU), CONCAT('UZS=', c.C_UZS), CONCAT('VEF=', c.C_VEF),
        //CONCAT('VND=', c.C_VND), CONCAT('VUV=', c.C_VUV), CONCAT('WST=', c.C_WST), CONCAT('YER=', c.C_YER),
        //CONCAT('ZAR=', c.C_ZAR), CONCAT('ZMK=', c.C_ZMK), CONCAT('TZS=', c.C_TZS), CONCAT('KRW=', c.C_KRW),
        //CONCAT('LAK=', c.C_LAK), CONCAT('RUB=', c.C_RUB), CONCAT('SYP=', c.C_SYP), CONCAT('TWD=', c.C_TWD)
        //        FROM country_new c
        //        INNER JOIN tblcurrencyname cn ON cn.currencyname = c.currency
        $country_currency_rates = [];

        if (($open = fopen(storage_path('app/seed') . "/country_currency_rates.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 10000, ",")) !== false) {
                $rates = [];
                foreach ($data as $key => $rate_data) {
                    if ($key > 2) {
                        $rate_data = explode('=', $rate_data);
                        $rates[$rate_data[0]] = (float)$rate_data[1];
                    }
                }

                $country_currency_rates[] = [
                    'country_id' => (int)$data[0],
                    'currency_id' => (int)$data[1],
                    'rates' => json_encode($rates),
                    'updated_at' => Carbon::parse($data[2]),
                    ];
            }
            fclose($open);
        }

        DB::table(CountryCurrencyRate::TABLE_NAME)->insertTs($country_currency_rates);
    }
}
