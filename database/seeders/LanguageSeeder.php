<?php

namespace Database\Seeders;

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

        if (($open = fopen(storage_path('app/seed') . "/languages.csv", "r")) !== FALSE)
        {
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $languages[] = [
                    'id' => $data[0],
                    'name' => $data[1],
                    'code' => $data[3],
                    'active' => $data[6]
                ];
            }

            fclose($open);
        }

        DB::table('languages')->insertTs($languages);
    }
}
