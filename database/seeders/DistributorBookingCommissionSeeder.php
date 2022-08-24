<?php

namespace Database\Seeders;

use App\Models\DistributorBookingCommission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorBookingCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distributors_booking_comissions = [];

        if (($open = fopen(storage_path('app/seed') . "/distributors_booking_comissions.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {

                $distributors_booking_comissions[] = [
                    'id' => (int)$data[0],
                    'company_id' => (int)$data[1],
                    'booking_id' => (int)$data[2],
                    'country_id' => !(int)$data[3] ? null : (int)$data[3],
                    'commission' => (int)$data[4],
                    'company_commission' => (int)$data[5],
                    'company_standard' => (int)$data[6],
                    'level' => (int)$data[7],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($distributors_booking_comissions, 1000) as $distributor_booking_comission) {
            DB::table(DistributorBookingCommission::TABLE_NAME)->insertTs($distributor_booking_comission);
        }
    }
}
