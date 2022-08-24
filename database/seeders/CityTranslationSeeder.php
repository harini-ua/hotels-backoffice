<?php

namespace Database\Seeders;

use App\Models\City;
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
        $translations_cities = [];

        if (($open = fopen(storage_path('app/seed') . "/translations_cities.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                // Fixed default city name
                $city_name = $data[4];
                if (in_array($data[4], [' ', ''], true)) {
                    $city = City::find((int) $data[2]);
                    if ($city) {
                        $city_name = $city->name;
                    }
                }

                $translations_cities[] = [
                    'id' => (int)$data[0],
                    'country_id' => (int)$data[1],
                    'city_id' => (int)$data[2],
                    'language_id' => (int)$data[3],
                    'city_name' => $city_name,
                    'translation' => in_array($data[5], [' ', ''], true) ? null : $data[5],
                ];
            }

            fclose($open);
        }

        DB::table(CityTranslation::TABLE_NAME)->insertTs($translations_cities);
    }
}
