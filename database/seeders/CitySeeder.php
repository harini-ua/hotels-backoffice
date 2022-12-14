<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $cities = [];

        if (($open = fopen(storage_path('app/seed') . "/cities.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $cities[] = [
                    'id' => $data[0],
                    'country_id' => $data[5],
                    'name' => $data[2],
                    'state' => $data[4] != '' ? $data[4] : null,
                    'active' => (int) $data[7],
                    'status' => $data[8] == 1 ? 0 : 1,
                    'blacklisted' => $data[8] == 3 ? 1 : 0,
                    'position' => DB::raw("(ST_GeomFromText('POINT($data[9] $data[10])'))"),
                    'hotels_count' => $data[12],
                    'popularity' => $data[13],
                ];
            }

            fclose($open);
        }

        DB::table(City::TABLE_NAME)->insertTs($cities);
    }
}
