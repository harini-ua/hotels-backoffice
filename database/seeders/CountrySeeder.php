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

        if (($open = fopen(storage_path('app/seed') . "/countries.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $countries[] = [
                    'id' => $data[0],
                    'currency_id' => 1,
                    'language_id' => $data[4],
                    'name' => $data[1],
                    'region' => $data[2],
                    'code' => $data[9],
                    'status' => $data[3]
                ];
            }

            fclose($open);
        }
        DB::table('countries')->insert($countries);
    }
}
