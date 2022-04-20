<?php

namespace Database\Seeders;

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

//SELECT w.whtid, c.id as country_id, hc.id as city_id, l.langid as lang_id, w.wht_name, w.company_name,
//w.category, w.address, w.email, w.mobile, w.status, w.clientlevel, w.vat, w.newsletter
//FROM white_profile_details w
// LEFT JOIN hei_country c ON w.country = c.country
//LEFT JOIN hei_city hc ON w.city = hc.city AND w.country = hc.country_name
//lEFT JOIN ml_tbl_language l ON w.language = l.langname
//WHERE c.id IN(1,2,7,8,18,23)

        if (($open = fopen(storage_path('app/seed') . "/companies.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $companies[] = [
                    'id' => (int)$data[0],
                    'country_id' => (int)$data[1],
                    'city_id' => (int)$data[2] == 0 ? null : (int)$data[2],
                    'language_id' => $data[3],
                    'holder_name' => $data[4],
                    'company_name' => $data[5],
                    'category' => $data[6],
                    'address' => $data[7],
                    'email' => $data[8],
                    'phone' => $data[9],
                    'status' => $data[10] == 'active' ? 1 : ($data[10] == 'inactive' ? 0 : 2),
                    'level' => strstr($data[11], 'level1') ? 1 : (strstr($data[11], 'level2') ? 2 : 0),
                    'vat' => $data[12] == 'yes' ? 1 : 0,
                    'newsletter' => $data[13] == 'yes' ? 1 : 0,
                ];
//        $table->id();dd
//        $table->string('holder_name');
//        $table->string('company_name');
//        $table->boolean('category');
//        $table->unsignedBigInteger('country_id');
//        $table->unsignedBigInteger('city_id');
//        $table->unsignedBigInteger('language_id');
//        $table->text('address');
//        $table->string('email')->unique();
//        $table->string('phone');
//        $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active, 2-pending');
//        $table->tinyInteger('level')->default(1)->comment('0-without level, 1-fist level, 2-second level');
//        $table->boolean('vat')->default(0);
//        $table->boolean('newsletter')->default(0);
                // (test, 0, 42906, wb85, 8, wb85@test.no, Penelope, 959, 34, 2, 0, , 1, 0)
            }

            fclose($open);
        }

        foreach (array_chunk($companies, 1000) as $company) {
            DB::table('companies')->insertTs($company);
        }
    }
}
