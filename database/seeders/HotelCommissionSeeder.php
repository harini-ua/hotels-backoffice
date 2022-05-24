<?php

namespace Database\Seeders;

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
        //SELECT h.hotel_code, h.commission FROM hotel h WHERE h.city IN(3629,14229,14314,23474,73417,23,8234,14851,74412,74583,11643,22242,29796,36967,72407,2792,20613,20771,20823,20473,21366,26365,68218,74445,3584,25732,33910,74559,76081) GROUP BY h.hotel_code

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
                DB::table('hotel_commissions')->insertTs($hotel_datas);
            }
        } else {
            DB::table('hotel_commissions')->insertTs($hotels_commissions);
        }
    }
}
