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

//for sub_companies.csv
//SELECT sw.*
// FROM sub_whitelabels sw
// WHERE sw.white_id IN(761,804,805,806,807,808,809,810,840,841,842,843,844,845,846,847,848,849,1184,1395,1396,1397,1398,1399,1400,1401,1402,1403,1404,1418,1419,1420,1421,1422,1423,1556,1594,1706,1707,1708,1709,1710,1711,1712,1713,754,602,886,425,431,443,462,494,496,497,501,503,516,518,524,568,570,571,587,604,605,616,640,645,682,693,712,719,723,724,732,746,748,750,790,962,1374,1526,1554,1595,1623,1626,1629,1727,1743)


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
