<?php

namespace Database\Seeders;

use App\Models\HotelCommission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotels_commissions = [];

        if (($open = fopen(storage_path('app/seed') . "/hotels_commissions.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $hotels_commissions[] = [
                    'hotel_id' => (int)$data[0],
                    'commission' => (int)$data[1],
                ];
            }

            fclose($open);
        }

        if (count($hotels_commissions) > 1000) {
            foreach (array_chunk($hotels_commissions, 1000) as $hotel_datas) {
                DB::table(HotelCommission::TABLE_NAME)->insertTs($hotel_datas);
            }
        } else {
            DB::table(HotelCommission::TABLE_NAME)->insertTs($hotels_commissions);
        }
    }
}
