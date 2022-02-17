<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $hotels = [];

//        SELECT h.hotel_code, h.city, h.blacklisting, h.hotel_update_status, h.isActive, h.star, h.name, REPLACE(REPLACE(h.description, '\r', ' '), '\n', ' ') as description, h.address, h.post_code, h.latitude, h.longitude, p.rating AS popularity, r.sort AS recommended, s.rating AS special_offer
//        FROM hotel h
//        LEFT JOIN popular_hotel p ON h.hotel_code = p.hotel_id LEFT JOIN recommended_hotel r ON h.hotel_code = r.hotel_id LEFT JOIN special_offer_hotel s ON h.hotel_code = s.hotel_id
//        WHERE h.city IN(3629,14229,14314,23474,73417,23,8234,14851,74412,74583,11643,22242,29796,36967,72407,2792,20613,20771,20823,20473,21366,26365,68218,74445,3584,25732,33910,74559,76081)
//        GROUP BY h.hotel_code

        if (($open = fopen(storage_path('app/seed') . "/hotels.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 0,',')) !== FALSE) {
                    if(count($data) < 15) {
                        var_dump($data);
                        exit();
                    }
                    $hotels[] = [
                        'id' => (int)$data[0],
                        'city_id' => (int)$data[1],
                        'status' => $data[2] == 1 ? 2 : ($data[3] == 1 ? 1 : 0),
                        'active' => (int)$data[4],
                        'rating' => (int)$data[5],
                        'name' => $data[6],
                        'description' => $data[7],
                        'address' => $data[8],
                        'postal_code' => $data[9],
                        'position' => DB::raw("(ST_GeomFromText('POINT($data[10] $data[11])'))"),
                        'popularity' => (int)$data[12],
                        'recommended' => (int)$data[13],
                        'special_offer' => (int)$data[14],
                    ];
                }

            fclose($open);
        }

        if(count($hotels) > 1000) {
            foreach (array_chunk($hotels,1000) as $hotel)
            {
                DB::table('hotels')->insert($hotel);
            }
        } else {
            DB::table('hotels')->insert($hotels);
        }
    }
}