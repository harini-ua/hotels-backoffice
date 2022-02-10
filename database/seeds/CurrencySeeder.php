<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [];

        if (($open = fopen(storage_path('app/seed') . "/currencies.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $currencies[] = [
                    'id' => $data[0],
                    'code' => $data[1]
                ];
            }

            fclose($open);
        }
        DB::table('currencies')->insert($currencies);
    }
}
