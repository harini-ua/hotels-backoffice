<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city_commission')->insertTs(
            [
                [
                    'city_id' => '8234',
                    'commission_id' => '2'
                ]
            ]
        );
    }
}
