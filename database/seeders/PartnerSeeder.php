<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partners = [];

        if (($open = fopen(storage_path('app/seed') . "/partners.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $partners[] = [
                    'id' => (int)$data[0],
                    'name' => $data[1],
                    'description' => $data[2] == 'NULL' ? null : $data[2],
                    'internal' => (int)$data[3],
                ];
            }
            fclose($open);
        }

        DB::table(Partner::TABLE_NAME)->insertTs($partners);
    }
}
