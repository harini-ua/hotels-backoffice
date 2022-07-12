<?php

namespace Database\Seeders;

use App\Models\MealPlan;
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
        DB::table(MealPlan::TABLE_NAME)->insertTs(
            [
                [
                    'name' => 'All inclusive',
                    'code'  => 'AI'
                ],
                [
                    'name' => 'Full board',
                    'code' => 'FB'
                ],
                [
                    'name' => 'Half board',
                    'code' => 'HB'
                ],
                [
                    'name' => 'Bed and breakfast',
                    'code' => 'BB'
                ],
                [
                    'name' => 'Room only',
                    'code' => 'RO'
                ],
            ]
        );
    }
}
