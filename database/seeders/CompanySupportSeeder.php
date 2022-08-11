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

//      for companies_support.csv
//      SELECT cs.whtid, cs.email, cs.phone, cs.hours, hc.id FROM white_customer_support cs
//      LEFT JOIN hei_country hc ON hc.country = cs.country
//      WHERE cs.whtid IN(761,804,805,806,807,808,809,810,840,841,842,843,844,845,846,847,848,849,1184,1395,1396,1397,1398,1399,1400,1401,1402,
//      1403,1404,1418,1419,1420,1421,1422,1423,1556,1594,1706,1707,1708,1709,1710,1711,1712,1713,754,602,886,425,431,443,462,
//      494,496,497,501,503,516,518,524,568,570,571,587,604,605,616,640,645,682,693,712,719,723,724,732,746,748,750,790,962,
//      1374,1526,1554,1595,1623,1626,1629,1727,1743)

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
