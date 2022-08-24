<?php

namespace Database\Seeders;

use App\Models\DiscountVoucherCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountVoucherCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discount_voucher_codes = [];

        if (($open = fopen(storage_path('app/seed') . "/discount_voucher_codes.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $discount_voucher_codes[] = [
                    'id' => (int)$data[0],
                    'discount_voucher_id' => (int)$data[1],
                    'code' => $data[2],
                    'status' => (int)$data[3],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($discount_voucher_codes, 1000) as $discount_voucher_code) {
            DB::table(DiscountVoucherCode::TABLE_NAME)->insertTs($discount_voucher_code);
        }
    }
}
