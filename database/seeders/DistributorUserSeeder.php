<?php

namespace Database\Seeders;

use App\Models\Distributor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (($open = fopen(storage_path('app/seed') . "/users.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {

                $distributor = Distributor::find((int)$data[9]);

                if($distributor) {
                    DB::table('distributor_user')->insertTs(
                        [
                            [
                                'distributor_id' => $distributor->id,
                                'user_id' => (int)$data[0],
                            ],
                        ]);
                }
            }

            fclose($open);
        }

    }
}
