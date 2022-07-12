<?php

namespace Database\Seeders;

use App\Models\Environment;
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
        DB::table(Environment::TABLE_NAME)->insertTs(
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
