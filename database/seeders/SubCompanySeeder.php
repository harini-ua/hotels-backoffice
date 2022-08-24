<?php

namespace Database\Seeders;

use App\Models\SubCompany;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub_companies = [];

        if (($open = fopen(storage_path('app/seed') . "/sub_companies.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {

                $sub_companies[] = [
                    'id' => (int)$data[0],
                    'company_id' => (int)$data[1],
                    'company_name' => $data[2],
                    'commission' => (int)$data[3],
                    'status' => (int)$data[4],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($sub_companies, 1000) as $company) {
            DB::table(SubCompany::TABLE_NAME)->insertTs($company);
        }
    }
}
