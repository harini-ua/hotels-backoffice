<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        DB::table('environments')->insertTs(
            [
                [
                    'name' => 'sandbox',
                ],
                [
                    'name' => 'live',
                ]
            ]
        );
    }
}
