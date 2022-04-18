<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //SELECT p.*, c.id as currency_id FROM partner_product p INNER JOIN tblcurrencyname c ON c.currencyname = p.currency

        $partner_products = [];

        if (($open = fopen(storage_path('app/seed') . "/partner_products.csv", "r")) !== FALSE)
        {
            while (($data = fgetcsv($open, 0,',')) !== FALSE) {

                $partner_products[] = [
                    'id' => (int)$data[0],
                    'name' => $data[3],
                    'code' => $data[1],
                    'meal_plan_id' => (int)($data[2]),
                    'currency_id' => (int)$data[26],
                    'partner_id' => (int)$data[25],
                    'price' => (double)$data[4],
                    'partner_pay_price' => (double)$data[5],
                    'partner_commission' => (int)$data[6],
                    'price_filter' => (int)$data[8],
                    'price_min' => (double)$data[9],
                    'price_max' => (double)$data[10],
                    'star_filter' => (int)$data[11],
                    'star_min' => (int)$data[12],
                    'star_max' => (int)$data[13],
                    'commission_min' => (double)$data[14],
                    'nights' => (int)$data[15],
                    'adults' => (int)$data[17],
                    'sold_online' => (int)$data[18],
                    'sold_retail' => (int)$data[19],
                    'sku' => $data[20] == '-' ? null : trim(preg_replace('/\s+/', ' ', $data[20])),
                    'comment' => $data[21] == '-' ? null : $data[21],
                ];
            }
            fclose($open);
        }

        DB::table('partner_product')->insertTs($partner_products);
    }
}
