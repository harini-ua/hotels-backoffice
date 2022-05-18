<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $countries = [];

        if (($open = fopen(storage_path('app/seed') . "/countries.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $countries[] = [
                    'id' => $data[0],
                    'currency_id' => 1,
                    'language_id' => $data[4],
                    'name' => ucwords(mb_strtolower($data[1])),
                    'region' => $data[2],
                    'code' => $data[9],
                    'active' => $data[3],
                    'blacklisted' => 0
                ];
            }

            fclose($open);
        }

        DB::table('countries')->insertTs($countries);
    }
}
