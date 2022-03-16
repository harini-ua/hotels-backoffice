<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel_images = [];

//        SELECT h.hotel_code, h.facility
//        FROM hotel h WHERE h.city IN(3629,14229,14314,23474,73417,23,8234,14851,74412,74583,11643,22242,29796,36967,72407,2792,20613,20771,20823,20473,21366,26365,68218,74445,3584,25732,33910,74559,76081)
//        GROUP BY h.hotel_code
        if (($open = fopen(storage_path('app/seed') . "/hotel_images.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 0,',')) !== FALSE) {
                if(!empty($data[1]) && $data[1] !== 'NULL') {
                    $images = explode('#*#', $data[1]);
                    foreach ($images as $image) {
                        if (!empty($image)) {
                            $image = trim($image);
                            $hotel_images[] = [
                                'hotel_id' => (int)$data[0],
                                'image' => $image,
                            ];
                        }
                    }
                }
            }

            fclose($open);
        }

        if(count($hotel_images) > 1000) {
            foreach (array_chunk($hotel_images,1000) as $hotel_image)
            {
                DB::table('hotel_images')->insertTs($hotel_image);
            }
        } else {
            DB::table('hotel_images')->insertTs($hotel_images);
        }
    }
}
