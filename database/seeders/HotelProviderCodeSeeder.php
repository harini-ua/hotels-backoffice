<?php

namespace Database\Seeders;

use App\Models\HotelProvider;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelProviderCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //for hotel_provider_codes.csv
//        SELECT hb.hotel_code, hb.provider_id, hb.provider_hotel_code, hb.tticode, hb.giataid, hb.isActive, hb.blacklisting, hb.name FROM hotel_binder hb
//        WHERE hb.hotel_code IN(49028,255450,259944,312993,363356,392987,395071,395863,396442,402300,450439,456817,496671,515170,520084,535299,2461426,
//        2461427,2461437,3170,3177,3190,3205,3211,3212,3213,3224,3227,3234,3238,3243,3245,3254,3257,3260,3282,3283,3289,3293,3294,
//        3320,3323,3335,3337,3343,3347,3377,3378,3382,3395,3398,3408,3411,49345,50332,51936,56209,56388,57077,59049,59057,59058,
//        59448,60088,60272,60322,61509,62065,63126,63564,63738,63744,63909,64164,64685,65507,65723,66435,66533,66543,66544,66545,
//        66819,66975,70213,70214,70277,70297,73524,73666,73681,74174,74247,75182,75354,76355,76637,76638,76817,78075,78124,78526,
//        78552,78589,78590,78795,79385,79386,79899,80278,81469,81907,82466,82472,82475,82476,82480,82505,82539,82953,84123,84126,
//        84131,84257,84869,85017,85636,85810,86197,86226,86281,86329,86416,86471,86493,86516,87211,88395,89030,91215,91237,91247,
//        91248,91668,93896,94336,96045,97033,97675,99618,101818,101941,101942,101943,101951,105230,106115,106533,106577,107843,
//        110123,120799,121435,124251,125092,126250,126251,130287,130815,1344)
        $hotelProviderCodes = [];

        if (($open = fopen(storage_path('app/seed') . "/hotel_provider_codes.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $hotelProviderCodes[] = [
                    'hotel_id' => (int)$data[0],
                    'provider_id' => (int)$data[1],
                    'provider_hotel_code' => $data[2],
                    'tti_code' => (int)$data[3],
                    'giata_code' => (int)$data[4],
                    'status' => 2,
                    'blacklisted' => (int)$data[5],
                    'hotel_name' => $data[6]
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($hotelProviderCodes, 1000) as $hotelProviderCodes) {
            DB::table(HotelProvider::TABLE_NAME)->insertTs($hotelProviderCodes);
        }
    }
}
