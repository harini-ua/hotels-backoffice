<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelProviderCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotelProviderCodes = [];

        if (($open = fopen(storage_path('app/seed') . "/hotel_provider_codes.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $hotelProviderCodes[] = [
                    'hotel_id' => (int)$data[0],
                    'provider_id' => (int)$data[1],
                    'provider_hotel_code' => $data[2],
                    'tti_code' => (int)$data[3],
                    'giata_code' => (int)$data[4],
                    'status' => 2,
                    'blacklisted' => (int)$data[5],
                    'hotel_name' => $data[6]
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($hotelProviderCodes, 1000) as $hotelProviderCodes) {
            DB::table('hotel_provider')->insertTs($hotelProviderCodes);
        }
    }
}
