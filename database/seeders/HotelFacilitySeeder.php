<?php

namespace Database\Seeders;

use App\Models\FacilityVariant;
use App\Models\HotelFacility;
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
        $facilities_rows = DB::table(FacilityVariant::TABLE_NAME)->select('facility_id', 'name')->get();
        $facilities_data = [];

        foreach ($facilities_rows as $facility_data) {
            $facilities_data[$facility_data->facility_id][] = $facility_data->name;
        }

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
                DB::table(HotelFacility::TABLE_NAME)->insertTs($sliceHotelFacilities);
            }
        } else {
            DB::table(HotelFacility::TABLE_NAME)->insertTs($hotelFacilities);
        }
    }
}
