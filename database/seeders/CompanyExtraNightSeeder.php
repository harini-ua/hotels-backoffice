<?php

namespace Database\Seeders;

use App\Models\CompanyExtraNight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyExtraNightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies_extra_nights = [];

        if (($open = fopen(storage_path('app/seed') . "/companies_extra_nights.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {

                $companies_extra_nights[] = [
                    'company_id' => (int)$data[0],
                    'currency_id' => (int)$data[1],
                    'partner_price' => (float)$data[2],
                    'customer_price' => (float)$data[3],
                    'enable' => (int)$data[4],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($companies_extra_nights, 1000) as $company_extra_nights) {
            DB::table(CompanyExtraNight::TABLE_NAME)->insertTs($company_extra_nights);
        }
    }
}
