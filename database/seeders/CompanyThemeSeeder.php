<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = [];

        if (($open = fopen(storage_path('app/seed') . "/company_themes.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $themes[] = [
                    'id' => (int)$data[0],
                    'theme_name' => $data[1],
                    'theme_color' => strtolower($data[2]),
                    'theme_stylesheet' => $data[3],
                ];
            }

            fclose($open);
        }

        DB::table('company_theme')->insert($themes);
    }
}
