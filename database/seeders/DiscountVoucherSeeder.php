<?php

namespace Database\Seeders;

use App\Models\DiscountVoucher;
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
                    'description' => in_array($data[8], [' ', '', '-'], true) ? null :  $data[8],
                    'commission_type' => (int)$data[10] == 0 || (int)$data[10] > 3 ? 1 : (int)$data[10],
                    'min_price' => (float)$data[16],
                    'expiry' => $data[9],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($discount_vouchers, 1000) as $discount_voucher) {
            DB::table(DiscountVoucher::TABLE_NAME)->insertTs($discount_voucher);
        }
    }
}
