<?php

namespace Database\Seeders;

use App\Models\CountryCurrencyRate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCurrencyRateSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $country_currency_rates = [];

        if (($open = fopen(storage_path('app/seed') . "/country_currency_rates.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 10000, ",")) !== false) {
                $rates = [];
                foreach ($data as $key => $rate_data) {
                    if ($key > 2) {
                        $rate_data = explode('=', $rate_data);
                        $rates[$rate_data[0]] = (float)$rate_data[1];
                    }
                }

                $country_currency_rates[] = [
                    'country_id' => (int)$data[0],
                    'currency_id' => (int)$data[1],
                    'rates' => json_encode($rates),
                    'updated_at' => Carbon::parse($data[2]),
                    ];
            }
            fclose($open);
        }

        DB::table(CountryCurrencyRate::TABLE_NAME)->insertTs($country_currency_rates);
    }
}
