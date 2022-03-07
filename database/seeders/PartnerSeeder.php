<?php

namespace Database\Seeders;

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

        if (($open = fopen(storage_path('app/seed') . "/partners.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 0,',')) !== FALSE) {

                $partners[] = [
                    'id' => (int)$data[0],
                    'name' => $data[1],
                    'description' => $data[2] == null ? null : $data[2],
                    'type' => (int)$data[3],
                ];
            }
            fclose($open);
        }

        DB::table('partners')->insert($partners);

    }
}
