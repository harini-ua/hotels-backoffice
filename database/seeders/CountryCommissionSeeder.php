<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (($open = fopen(storage_path('app/seed') . "/country_commissions.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $country = Country::find((int)$data[4]);

                if ($country) {
                    $country->update([
                        'commission' => (int)$data[2]
                    ]);
                }
            }

            fclose($open);
        }
    }
}
