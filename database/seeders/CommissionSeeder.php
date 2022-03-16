<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commissions')->insertTs(
            [
                [
                    'name' => 'country commission'
                ],
                [
                    'name' => 'city commission'
                ],
                [
                    'name' => 'hotel commission'
                ],
                [
                    'name' => 'company booking commission'
                ],
                [
                    'name' => 'company sale commission'
                ],
            ]
        );
    }
}
