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
        $hotelFacilities = [];
        $facilities_rows = DB::table('facility_variants')->select('facility_id', 'name')->get();
        $facilities_data = [];
        foreach ($facilities_rows as $facility_data) {
            $facilities_data[$facility_data->facility_id][] = $facility_data->name;
        }
//        SELECT h.hotel_code, h.facility
//        FROM hotel h WHERE h.city IN(3629,14229,14314,23474,73417,23,8234,14851,74412,74583,11643,22242,29796,36967,72407,2792,20613,20771,20823,20473,21366,26365,68218,74445,3584,25732,33910,74559,76081)
//        GROUP BY h.hotel_code
        if (($open = fopen(storage_path('app/seed') . "/hotel_facilities.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                if (!empty($data[1]) && $data[1] !== 'NULL') {
                    $facilities = explode('#*#', $data[1]);
                    $facility_ids = [];
                    foreach ($facilities as $facility) {
                        if (!empty($facility)) {
                            $facility = strtolower(trim(str_replace('YES', '', $facility)));
                            foreach ($facilities_data as $key => $facility_data) {
                                if (in_array($facility, $facility_data, true) && !in_array($key, $facility_ids, true)) {
                                    $facility_ids[] = $key;
                                    $hotelFacilities[] = [
                                        'hotel_id' => (int)$data[0],
                                        'facility_id' => $key,
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            fclose($open);
        }

        if (count($hotelFacilities) > 1000) {
            foreach (array_chunk($hotelFacilities, 1000) as $sliceHotelFacilities) {
                DB::table('hotel_facility')->insertTs($sliceHotelFacilities);
            }
        } else {
            DB::table('hotel_facility')->insertTs($hotelFacilities);
        }
    }
}
