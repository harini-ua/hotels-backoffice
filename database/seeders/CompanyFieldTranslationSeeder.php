<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyFieldTranslationSeeder extends Seeder
{
    /**
     * Run the database seeders.
     * On full database import add company_field_translations.csv and uncomment CompanyFieldTranslationSeeder in DatabaseSeeder
     * @return void
     */
    public function run()
    {
        $company_field_translations = [];

        if (($open = fopen(storage_path('app/seed') . "/company_field_translations.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $company_field_translations[] = [
                    'id' => (int)$data[0],
                    'field_id' => (int)$data[1],
                    'company_id' => (int)$data[4],
                    'language_id' => (int)$data[3],
                    'country_id' => (int)$data[5],
                    'name' => $data[6],
                    'translation' => $data[7],
                    'status' => (int)$data[8],
                    'is_duplicate' => (int)$data[9],
                    'created_at' => Carbon::parse($data[11]),
                    'updated_at' => Carbon::parse($data[10]),
                ];
            }

            fclose($open);
        }
        foreach (array_chunk($company_field_translations, 1000) as $translations) {
            DB::table('company_field_translations')->insertTs($translations);
        }
    }
}
