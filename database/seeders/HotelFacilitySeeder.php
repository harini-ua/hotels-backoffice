<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel_facilities = [];

//        SELECT h.hotel_code, h.facility
//        FROM hotel h WHERE h.city IN(3629,14229,14314,23474,73417,23,8234,14851,74412,74583,11643,22242,29796,36967,72407,2792,20613,20771,20823,20473,21366,26365,68218,74445,3584,25732,33910,74559,76081)
//        GROUP BY h.hotel_code
        if (($open = fopen(storage_path('app/seed') . "/hotel_facilities.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 0,',')) !== FALSE) {
                if(!empty($data[1]) && $data[1] !== 'NULL') {
                    $facilities = explode('#*#', $data[1]);
                    $facility_ids = [];
                    foreach ($facilities as $facility) {
                        if (!empty($facility)) {
                            $facility = strtolower(trim(str_replace('YES', '', $facility)));
                            $facility_id = DB::table('facility_variants')->select('facility_id')->where('name', $facility)->first();
                            if (isset($facility_id->facility_id) && !in_array($facility_id->facility_id, $facility_ids)) {
                                $facility_ids[] = $facility_id->facility_id;
                                $hotel_facilities[] = [
                                    'hotel_id' => (int)$data[0],
                                    'facility_id' => $facility_id->facility_id,
                                ];
                            }
                        }
                    }
                }
//                var_dump($hotel_facilities);
//                exit();

            }

            fclose($open);
        }

        if(count($hotel_facilities) > 1000) {
            foreach (array_chunk($hotel_facilities,1000) as $hotel_facility)
            {
                DB::table('hotel_facilities')->insert($hotel_facility);
            }
        } else {
            DB::table('hotel_facilities')->insert($hotel_facilities);
        }
    }
}
