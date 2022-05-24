<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distributor_countries = [];
        if (($open = fopen(storage_path('app/seed') . "/distributors.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $country_names = array_filter(explode('|', $data[6]));
                $countries_ids = DB::table('countries')
                    ->select('id')
                    ->whereIn('name', array_values($country_names))
                    ->get();
                if (!empty($countries_ids)) {
                    foreach ($countries_ids as $countries_id) {
                        $distributor_countries[] = [
                            'distributor_id' => (int)$data[0],
                            'country_id' => $countries_id->id,
                        ];
                    }
                }
            }

            fclose($open);
        }

        foreach (array_chunk($distributor_countries, 1000) as $distributor_countries_data) {
            DB::table('distributor_country')->insertTs($distributor_countries_data);
        }
    }
}
