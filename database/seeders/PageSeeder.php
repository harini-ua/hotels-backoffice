<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $pages = [];

        if (($open = fopen(storage_path('app/seed') . "/pages.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $pages[] = [
                    'id' => (int)$data[0],
                    'name' => $data[1],
                    'order' => (int)$data[2],
                ];
            }

            fclose($open);
        }

        DB::table('pages')->insertTs($pages);
    }
}
