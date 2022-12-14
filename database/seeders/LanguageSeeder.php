<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $languages = [];

        if (($open = fopen(storage_path('app/seed') . "/languages.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $languages[] = [
                    'id' => $data[0],
                    'name' => $data[1],
                    'translation' => $data[2],
                    'code' => $data[3],
                    'payex_code' => $data[4],
                    'active' => $data[6]
                ];
            }

            fclose($open);
        }

        DB::table(Language::TABLE_NAME)->insertTs($languages);
    }
}
