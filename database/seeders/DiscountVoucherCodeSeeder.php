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

//for discount_voucher_codes.csv
//SELECT id, discount_voucher_id, code, status FROM discount_codes WHERE discount_voucher_id IN(1,34,50,51,53,55,56,66,98,151,156,170,185,260,267,268,283,290,294,303,313,315,321,323,326,329,331,332,337,352,353,354,355,357,365,428,436,500,501,503,504,506,507,508,509,510,511,512,513,514,515,516,548,551,631,670,94,146,147,148,316,318,412,418,430,431,434,435,320,52,81,280,322,12,14,27,31,65,67,69,142,163,173,190,293,295,297,299,312,333,339,340,343,344,345,346,351,356,358,359,360,361,363,364,366,367,368,369,371,374,376,377,381,384,385,387,389,392,393,396,397,398,416,417,419,422,423,424,425,429,433,437,438,439,440,502,550,553,563,564,570,571,572,573,634,635,636,637,647,651,652,698,700,701,472,330,276,85,139,13,15,16,28,29,30,157,183,278,279,319,443,473,474,655,689,63,68,461,213,215,420,633,697,699)

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
