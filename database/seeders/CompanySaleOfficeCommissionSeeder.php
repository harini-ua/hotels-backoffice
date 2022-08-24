<?php

namespace Database\Seeders;

use App\Models\CompanySaleOfficeCommission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySaleOfficeCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies_sale_office_comissions = [];

        if (($open = fopen(storage_path('app/seed') . "/companies_sale_office_comissions.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $companies_sale_office_comissions[] = [
                    'company_id' => (int)$data[0],
                    'sale_office_country_id' => !(int)$data[1] ? null : (int)$data[1],
                    'commission' => (int)$data[2],
                    'level' => (int)$data[3],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($companies_sale_office_comissions, 1000) as $company_sale_office_comission) {
            DB::table(CompanySaleOfficeCommission::TABLE_NAME)->insertTs($company_sale_office_comission);
        }
    }
}
