<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('environments')->insert(
            [
                [
                    'environment_name' => 'sandbox'
                ],
                [
                    'environment_name' => 'live'
                ]
            ]
        );
    }
}
