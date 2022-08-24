<?php

namespace Database\Seeders;

use App\Models\HotelDistance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelDistanceSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $hotel_distances = [];

        if (($open = fopen(storage_path('app/seed') . "/hotel_distances.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $hotel_distances[] = [
                    'id' => (int)$data[0],
                    'hotel_id' => (int)$data[1],
                    'place' => $data[2],
                    'unit' => $data[3],
                    'distance' => (int)$data[4],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($hotel_distances, 1000) as $hotel_distance) {
            DB::table(HotelDistance::TABLE_NAME)->insertTs($hotel_distance);
        }
    }
}
