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

//        SELECT h.hotel_code, h.city, h.blacklisting, h.hotel_update_status, h.delete_status, h.star, h.name,
//        REPLACE(REPLACE(h.description, '\r', ' '), '\n', ' ') as description, h.address, h.post_code, h.latitude,
//        h.longitude, p.rating AS popularity, r.sort AS recommended, s.rating AS special_offer, h.priority_rating, ha.other_rating,
//        h.commission, h.taplaceid, h.tareviewcount, h.talangratingurl, h.city_code, h.city_name, h.country, h.country_code,
//        h.country_name, h.email, h.telephone, h.fax, h.website, h.giata_image_downloaded
//        FROM hotel h
//        LEFT JOIN popular_hotel p ON h.hotel_code = p.hotel_id
//        LEFT JOIN recommended_hotel r ON h.hotel_code = r.hotel_id
//        LEFT JOIN special_offer_hotel s ON h.hotel_code = s.hotel_id
//        LEFT JOIN hotel_additional_data ha ON h.hotel_code = ha.hotel_id
//        WHERE h.city IN(3629,14229,14314,23474,73417,23,8234,14851,74412,74583,11643,22242,29796,36967,72407,2792,20613,20771,20823,20473,21366,26365,68218,74445,3584,25732,33910,74559,76081)
//        GROUP BY h.hotel_code

        if (($open = fopen(storage_path('app/seed') . "/hotels.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $hotels[] = [
                    'id' => (int)$data[0],
                    'city_id' => (int)$data[1],
                    'city_code' => (int)$data[21],
                    'city_name' => $data[22],
                    'country_id' => (int)$data[23],
                    'country_code' => $data[24],
                    'country_name' => $data[25],
                    'blacklisted' => $data[2],
                    'status' => (int)$data[4] == 1 ? 4 : 3,
                    'rating' => (int)$data[5],
                    'name' => $data[6],
                    'description' => in_array($data[7], ['', ' '], true) ? null : $data[7],
                    'address' => in_array($data[8], ['', ' '], true) ? null : $data[8],
                    'postal_code' => in_array($data[9], ['', ' '], true) ? null : $data[9],
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
                    'email' => $data[26] === null || $data[26] === '' ? null : $data[26],
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
