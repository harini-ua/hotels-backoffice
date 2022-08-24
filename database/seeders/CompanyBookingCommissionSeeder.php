<?php

namespace Database\Seeders;

use App\Models\CompanyBookingCommission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyBookingCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies_booking_comissions = [];

        if (($open = fopen(storage_path('app/seed') . "/companies_booking_comissions.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {

                $companies_booking_comissions[] = [
                    'company_id' => (int)$data[0],
                    'standard_commission' => (int)$data[1],
                    'booking_commission' => (int)$data[2],
                    'payback_to_client' => (int)$data[4],
                    'minimal_commission' => (double)$data[5],
                    'use_minimal_commission' => (int)$data[6],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($companies_booking_comissions, 1000) as $company_booking_comission) {
            DB::table(CompanyBookingCommission::TABLE_NAME)->insertTs($company_booking_comission);
        }
    }
}
