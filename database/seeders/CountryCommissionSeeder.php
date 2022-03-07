<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country_commissions = [];

        if (($open = fopen(storage_path('app/seed') . "/country_commissions.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 0,',')) !== FALSE) {

                $country_commissions[] = [
                    'country_id' => (int)$data[4],
                    'commission_id' => 1,
                    'commission' => (int)$data[2],
                ];

            }

            fclose($open);
        }

        DB::table('country_commission')->insert($country_commissions);

    }
}
