<?php

namespace Database\Seeders;

use App\Models\CompanySupport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies_support = [];

        if (($open = fopen(storage_path('app/seed') . "/companies_support.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {

                $companies_support[] = [
                    'company_id' => (int)$data[0],
                    'country_id' => (int)$data[4] == 0 ? null : (int)$data[4],
                    'email' => $data[1],
                    'phone' => $data[2],
                    'work_hours' => $data[3],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($companies_support, 1000) as $company_support) {
            DB::table(CompanySupport::TABLE_NAME)->insertTs($company_support);
        }
    }
}
