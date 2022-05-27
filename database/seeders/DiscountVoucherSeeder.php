<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//for discount_vouchers.csv
//SELECT d.*, c.id as currency_id FROM discount_voucher d LEFT JOIN tblcurrencyname c ON c.currencyname = d.currency_or_percent
//WHERE d.white_label_id IN(761,804,805,806,807,808,809,810,840,841,842,843,844,845,846,847,848,849,1184,1395,1396,1397,1398,1399,1400,1401,1402,1403,1404,1418,1419,1420,1421,1422,1423,1556,1594,1706,1707,1708,1709,1710,1711,1712,1713,754,602,886,425,431,443,462,494,496,497,501,503,516,518,524,568,570,571,587,604,605,616,640,645,682,693,712,719,723,724,732,746,748,750,790,962,1374,1526,1554,1595,1623,1626,1629,1727,1743)

        $discount_vouchers = [];

        if (($open = fopen(storage_path('app/seed') . "/discount_vouchers.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $discount_vouchers[] = [
                    'id' => (int)$data[0],
                    'name' => $data[3],
                    'voucher_type' => (int)$data[4],
                    'voucher_codes_count' => (int)$data[5],
                    'amount' => (float)$data[6],
                    'amount_type' => $data[7] == '' || $data[7] == 'percent' ? 1 : 0,
                    'currency_id' => !(int)$data[17] ? NULL : (int)$data[17],
                    'company_id' => (int)$data[2],
                    'description' => $data[8],
                    'commission' => (int)$data[10] == 0 || (int)$data[10] > 3 ? 1 : (int)$data[10],
                    'min_price' => (float)$data[16],
                    'expiry' => $data[9],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($discount_vouchers, 1000) as $discount_voucher) {
            DB::table('discount_vouchers')->insertTs($discount_voucher);
        }
    }
}
