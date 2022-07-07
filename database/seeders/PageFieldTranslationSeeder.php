<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageFieldTranslationSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $page_field_translations = [];

        if (($open = fopen(storage_path('app/seed') . "/page_field_translations.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $page_field_translations[] = [
                    'id' => (int)$data[0],
                    'field_id' => (int)$data[1] == 0 ? null : (int)$data[1],
                    'page_id' => (int)$data[2],
                    'country_id' => (int)$data[4] == 0 ? null : (int)$data[4],
                    'language_id' => (int)$data[3],
                    'name' => $data[5],
                    'translation' => $data[6],
                    'status' => (int)$data[7],
                    'is_duplicate' => $data[8],
                    'created_at' => Carbon::parse($data[10]),
                    'updated_at' => Carbon::parse($data[9]),
                ];
            }

            fclose($open);
        }

        DB::table('page_field_translations')->insertTs($page_field_translations);
    }
}
