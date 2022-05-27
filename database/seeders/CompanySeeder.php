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
        $company_user = [];

//for companies.csv
//SELECT w.whtid, c.id as country_id, hc.id as city_id, l.langid as lang_id, w.wht_name, w.company_name, w.category,
// w.address, w.email, w.mobile, w.status, w.clientlevel, w.vat, w.newsletter, w.comments,
// (IF(w.wht_cht_id != '0', 1 + (SELECT COUNT(*) FROM tblaccesscodes ac WHERE ac.whtid = w.whtid),
// (SELECT COUNT(*) FROM tblaccesscodes ac WHERE ac.whtid = w.whtid))) as access_codes_count_total, w.hei as admin_id
// FROM white_profile_details w
// LEFT JOIN hei_country c ON w.country = c.country
// LEFT JOIN hei_city hc ON w.city = hc.city AND w.country = hc.country_name
// lEFT JOIN ml_tbl_language l ON w.language = l.langname
// LEFT JOIN login lg ON lg.usertypeid = w.whtid AND lg.usertype = 'whitelabel'
// WHERE hc.id IN(3629,14229,14314,23474,73417,23,8234,14851,74412,74583,11643,22242,29796,36967,72407,2792,20613,20771,20823,20473,21366,26365,68218,74445,3584,25732,33910,74559,76081)
// ORDER BY `lang_id` ASC

//for company_user.csv
//SELECT w.whtid, l.id as user_id FROM white_profile_details w LEFT JOIN login l ON w.whtid = l.usertypeid  WHERE l.usertype = 'whitelabel'

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
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($companies, 1000) as $company) {
            DB::table('companies')->insertTs($company);
        }
    }
}
