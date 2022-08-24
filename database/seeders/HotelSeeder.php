<?php

namespace Database\Seeders;

use App\Models\Hotel;
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

        if (($open = fopen(storage_path('app/seed') . "/hotels.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $hotels[] = [
                    'id' => (int)$data[0],
                    'city_id' => (int)$data[1],
                    'city_code' => in_array($data[21], ['', ' ', 'NULL'], true) ? null : (int)$data[21],
                    'city_name' => in_array($data[22], ['', ' ', 'NULL'], true) ? null : $data[22],
                    'country_id' => (int)$data[23],
                    'country_code' => in_array($data[24], ['', ' ', 'NULL'], true) ? null : $data[24],
                    'country_name' => in_array($data[25], ['', ' ', 'NULL'], true) ? null : $data[25],
                    'blacklisted' => $data[2],
                    'status' => (int)$data[4] == 1 ? 4 : 3,
                    'rating' => (int)$data[5],
                    'name' => $data[6],
                    'description' => in_array($data[7], ['', ' '], true) ? null : $data[7],
                    'address' => in_array($data[8], ['', ' '], true) ? null : $data[8],
                    'postal_code' => in_array($data[9], ['', ' ', 'NULL'], true) ? null : $data[9],
                    'position' => DB::raw("(ST_GeomFromText('POINT($data[11] $data[10])'))"),
                    'priority_rating' => (int)$data[15],
                    'popularity' => (int)$data[12] > 0 ? 1 : 0,
                    'recommended' => (int)$data[13],
                    'special_offer' => (int)$data[14],
                    'other_rating' => (int)$data[16],
                    'commission' => (int)$data[17],
                    'trip_advisor_rating_id' => (int)$data[18],
                    'trip_advisor_rating_count' => (int)$data[19],
                    'trip_advisor_rating_url' => in_array($data[20], ['', ' ', 'NULL'], true) || $data[20] === null ? null : $data[20],
                    'email' => in_array($data[26], ['', ' ', 'NULL'], true) || $data[26] === null ? null : $data[26],
                    'phone' => $data[27] === null || $data[27] === '' ? null : $data[27],
                    'fax' => $data[28] === null || $data[28] === '' ? null : $data[28],
                    'website' => $data[29] === null || $data[29] === '' ? null : $data[29],
                    'giata_image_downloaded' => (int)$data[30],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($hotels, 1000) as $hotel_datas) {
            DB::table(Hotel::TABLE_NAME)->insertTs($hotel_datas);
        }
    }
}
