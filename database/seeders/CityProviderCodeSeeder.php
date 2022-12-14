<?php

namespace Database\Seeders;

use App\Models\CityProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityProviderCodeSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $cityProviderCodes = [];

        if (($open = fopen(storage_path('app/seed') . "/city_provider_codes.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                if ((int)$data[5] !== 5) {
                    $cityProviderCodes[] = [
                        'id' => (int)$data[0],
                        'city_id' => (int)$data[7],
                        'provider_id' => (int)$data[5],
                        'provider_city_code' => $data[3],
                        'status' => $data[9] == 1 ? 1 : 0,
                        'active' => $data[12]
                    ];
                }
            }
            fclose($open);
        }

        DB::table(CityProvider::TABLE_NAME)->insertTs($cityProviderCodes);
    }
}
