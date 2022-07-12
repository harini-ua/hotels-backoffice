<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [];

        if (($open = fopen(storage_path('app/seed') . "/currencies.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $currencies[] = [
                    'id' => $data[0],
                    'code' => $data[1]
                ];
            }

            fclose($open);
        }

        DB::table(Currency::TABLE_NAME)->insertTs($currencies);
    }
}
