<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageFieldTranslationSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        //SELECT *  FROM ml_lang_translation WHERE translation_id != 0 AND (fieldid = 0 OR fieldid IN(0,1,2,818,819,820,821,822,836,855,858,859,863,929,970,1025,1031,1032,3,4,5,6,7,8,9,10,11,12,13,14,15,16,
        //18,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,43,45,46,47,839,840,842,843,844,867,868,869,870,960,963,964,965,966,971,
        //972,995,996,1034,1038,1039,1065,1073,1074,1076,1077,1113,1114,1181,1182,48,49,50,51,52,53,54,968,969,973,55,989,56,988,57,865,922,992,58,59,
        //826,933,934,935,991,1001,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,857,860,861,862,864,871,920,936,937,938,961,
        //976,1027,1028,1029,1087,1088,1194,1222,1223,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,
        //854,951,952,955,967,975,113,115,116,117,118,119,1024,120,121,122,123,124,125,126,129,130,131,132,133,135,136,137,138,139,140,141,142,143,144,
        //145,146,147,828,829,830,831,832,833,834,838,856,888,889,890,891,892,915,916,917,921,940,941,942,943,949,950,997,998,999,1000,1030,1033,1035,1036,1037,1063,1064,1091,1092,1093,1094,1095,1098,1099,1106,1115,1117,1118,112))

        $page_field_translations = [];

        if (($open = fopen(storage_path('app/seed') . "/page_field_translations.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 10000, ",")) !== false) {
                $page_field_translations[] = [
                    'id' => (int)$data[0],
                    'field_id' => (int)$data[1] == 0 ? null : (int)$data[1],
                    'page_id' => (int)$data[2],
                    'country_id' => (int)$data[4] == 0 ? null : (int)$data[4],
                    'language_id' => (int)$data[3],
                    'name' => $data[5],
                    'translation' => $data[6],
                    'status' => (int)$data[7],
                    'is_duplicate' => (int)$data[8],
                    'created_at' => Carbon::parse($data[10]),
                    'updated_at' => Carbon::parse($data[9]),
                ];
            }

            fclose($open);
        }
        foreach (array_chunk($page_field_translations, 1000) as $translations) {
            DB::table('page_field_translations')->insertTs($translations);
        }
    }
}
