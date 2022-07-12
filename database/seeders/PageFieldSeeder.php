<?php

namespace Database\Seeders;

use App\Models\PageField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageFieldSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $page_fields = [];

        if (($open = fopen(storage_path('app/seed') . "/page_fields.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $page_fields[] = [
                    'id' => (int)$data[0],
                    'page_id' => (int)$data[1],
                    'name' => $data[2],
                    'type' => (int)$data[3],
                    'max_length' => (int)$data[4],
                    'is_mobile' => (int)$data[5],
                ];
            }

            fclose($open);
        }

        DB::table(PageField::TABLE_NAME)->insertTs($page_fields);
    }
}
