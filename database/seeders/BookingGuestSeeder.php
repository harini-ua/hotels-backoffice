<?php

namespace Database\Seeders;

use App\Models\BookingGuest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingGuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//for booking_guests.csv
//        SELECT * FROM book_passanger_info
//        WHERE booking_id IN(2199268,2204532,2208448,2208930,2208931,2208940,2208967,2228046,2228118,2234167,2237076,2244511,2249685,2254541,2258871,2259822,
//        2259829,2259830,2259831,2259841,2259842,2259937,2259958,2260197,2260472,2264285,2267048,2269080,2273046,2274046,2274288,2274965,2282022,2283023,2284261,
//        2284381,2285069,2285146,2285392,2285555,2285710,2288343,2291941,2293953,2294337,2295855,2295856,2295861,2295866,2295868,2295875,2296060,2296089,2296583,
//        2296585,2299591,2301454,2305084,2305085,2305086,2305286,2306378,2306384,2306387,2307708,2309086,2310134,2310135,2310639,2310829,2314872,2316454,2320603,
//        2321358,2321947,2322470,2322746,2323069,2324669,2328594,2329013,2332603,2333036,2336757,2337515,2340483,2340763,2341008,2341009,2341345,2342320,2344298,
//        2344321,2344322,2344323,2344325,2344326,2344327,2346077,2346078,2346079,2351606,2352668,2352756,2353147,2353150,2353151,2201509,2208933,2208968,2208970,
//        2219625,2221994,2230910,2232475,2249274,2254328,2259828,2265256,2265799,2267107,2276124,2277333,2277355,2277356,2281216,2281223,2287552)


        $booking_guests = [];

        if (($open = fopen(storage_path('app/seed') . "/booking_guests.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $booking_guests[] = [
                    'id' => (int)$data[0],
                    'booking_id' => (int)$data[6],
                    'firstname' => $data[2],
                    'lastname' => $data[3],
                    'guest_type' => $data[5] === 'adult' ? 0 : 1,
                    'child_age' => $data[5] === 'child' ? (int)$data[12] : null,
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($booking_guests, 1000) as $booking_guest) {
            DB::table(BookingGuest::TABLE_NAME)->insertTs($booking_guest);
        }
    }
}
