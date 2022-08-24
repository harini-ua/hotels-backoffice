<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [];
        $company_user = [];

        if (($company_user_data = fopen(storage_path('app/seed') . "/company_user.csv", "r")) !== false) {
            while (($data_users = fgetcsv($company_user_data, 0, ',')) !== false) {
                $company_user[$data_users[0]] = $data_users[1];
            }
            fclose($company_user_data);
        }

        if (($open = fopen(storage_path('app/seed') . "/companies.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {

                $companies[] = [
                    'id' => (int)$data[0],
                    'country_id' => (int)$data[1],
                    'city_id' => (int)$data[2] == 0 ? null : (int)$data[2],
                    'language_id' => (int)$data[3] == 0 ? null : $data[3],
                    'admin_id' => (int)$data[16] == 1 ? 519 : ((int)$data[16] == 2 ? 521 : 522),
                    'user_id' => isset($company_user[(int)$data[0]]) ? $company_user[(int)$data[0]] : null,
                    'holder_name' => $data[4],
                    'company_name' => $data[5],
                    'category' => $data[6],
                    'address' => $data[7],
                    'email' => $data[8],
                    'phone' => $data[9],
                    'comment' => $data[14],
                    'status' => $data[10] == 'active' ? 1 : ($data[10] == 'inactive' ? 0 : 2),
                    'level' => strstr($data[11], 'level1') ? 1 : (strstr($data[11], 'level2') ? 2 : 0),
                    'vat' => $data[12] == 'yes' ? 1 : 0,
                    'newsletter' => $data[13] == 'yes' ? 1 : 0,
                    'login_type' => $data[15] == 0 ? 2 : ($data[15] == 1 ? 1 : 0),
                    'access_codes' => $data[15],
                    'sub_companies' => (int)$data[17],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($companies, 1000) as $company) {
            DB::table(Company::TABLE_NAME)->insertTs($company);
        }
    }
}
