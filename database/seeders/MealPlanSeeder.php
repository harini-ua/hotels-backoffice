<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meal_plans')->insertTs(
            [
                [
                    'name' => 'all inclusive',
                    'code'  => 'AI'
                ],
                [
                    'name' => 'full board',
                    'code' => 'FB'
                ],
                [
                    'name' => 'half board',
                    'code' => 'HB'
                ],
                [
                    'name' => 'bed and breakfast',
                    'code' => 'BB'
                ],
                [
                    'name' => 'room only',
                    'code' => 'RO'
                ],
            ]
        );
    }
}
