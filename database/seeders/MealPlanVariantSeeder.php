<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealPlanVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meal_plans_variants')->insert(
            [
                [
                    'meal_plan_id' => 1,
                    'name' => 'all inclusive',
                    'code' => 'AS',
                ],
                [
                    'meal_plan_id' => 1,
                    'name' => 'all inclusive',
                    'code' => 'AG',
                ],
                [
                    'meal_plan_id' => 1,
                    'name' => 'all inclusive',
                    'code' => 'AI',
                ],
                [
                    'meal_plan_id' => 1,
                    'name' => 'all inclusive',
                    'code' => 'TI',
                ],
                [
                    'meal_plan_id' => 2,
                    'name' => 'full board',
                    'code' => 'FB',
                ],
                [
                    'meal_plan_id' => 2,
                    'name' => 'full board',
                    'code' => 'PC',
                ],
                [
                    'meal_plan_id' => 2,
                    'name' => 'full board and beverage',
                    'code' => 'FV',
                ],
                [
                    'meal_plan_id' => 3,
                    'name' => 'half board',
                    'code' => 'HB',
                ],
                [
                    'meal_plan_id' => 3,
                    'name' => 'half board',
                    'code' => 'MP',
                ],
                [
                    'meal_plan_id' => 3,
                    'name' => 'half board',
                    'code' => 'FH',
                ],
                [
                    'meal_plan_id' => 3,
                    'name' => 'half board and beverage',
                    'code' => 'HV',
                ],
                [
                    'meal_plan_id' => 4,
                    'name' => 'bed and breakfast and 1 half board',
                    'code' => 'BH',
                ],
                [
                    'meal_plan_id' => 4,
                    'name' => 'breakfast and ski pass',
                    'code' => 'BS',
                ],
                [
                    'meal_plan_id' => 4,
                    'name' => 'continental breakfast',
                    'code' => 'CB',
                ],
                [
                    'meal_plan_id' => 4,
                    'name' => 'english breakfast',
                    'code' => 'EB',
                ],
                [
                    'meal_plan_id' => 4,
                    'name' => 'american breakfast',
                    'code' => 'AB',
                ],
                [
                    'meal_plan_id' => 5,
                    'name' => 'room only',
                    'code' => 'RO',
                ],
                [
                    'meal_plan_id' => 5,
                    'name' => 'room only',
                    'code' => 'OB',
                ],
                [
                    'meal_plan_id' => 5,
                    'name' => 'room only',
                    'code' => 'SA',
                ],
                [
                    'meal_plan_id' => 5,
                    'name' => 'room only',
                    'code' => 'SB',
                ],
                [
                    'meal_plan_id' => 5,
                    'name' => 'room only',
                    'code' => 'SC',
                ],
            ]
        );
    }
}
