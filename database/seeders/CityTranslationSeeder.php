<?php

namespace Database\Seeders;

use App\Models\CityTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTranslationSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        //SELECT * FROM `hei_city_translation`WHERE city_id IN(3629,14229,14314,23474,73417,23,8234,14851,74412,74583,
        //11643,22242,29796,36967,72407,2792,20613,20771,20823,20473,21366,26365,68218,74445,3584,25732,33910,74559,76081)
        //AND language_id != 0
        $translations_cities = [];

        if (($open = fopen(storage_path('app/seed') . "/translations_cities.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $translations_cities[] = [
                    'id' => (int)$data[0],
                    'country_id' => (int)$data[1],
                    'city_id' => (int)$data[2],
                    'language_id' => (int)$data[3],
                    'city_name' => $data[4],
                    'translation' => $data[5],
                ];
            }

            fclose($open);
        }

        DB::table(CityTranslation::TABLE_NAME)->insertTs($translations_cities);
    }
}
