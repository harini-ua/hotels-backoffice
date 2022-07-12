<?php

namespace Database\Seeders;

use App\Models\Distributor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distributors = [];


        if (($open = fopen(storage_path('app/seed') . "/distributors.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $distributors[] = [
                    'id' => (int)$data[0],
                    'name' => $data[1],
                    'email' => $data[2],
                    'address' => $data[3],
                    'phone' => $data[5],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($distributors, 1000) as $distributor) {
            DB::table(Distributor::TABLE_NAME)->insertTs($distributor);
        }
    }
}
