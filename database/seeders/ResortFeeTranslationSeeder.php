<?php

namespace Database\Seeders;

use App\Models\ResortFeeTranslation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResortFeeTranslationSeeder extends Seeder
{
    /**
     * Run the database seeders.
     * @return void
     */
    public function run()
    {
        $resort_fee_translations = [];

        if (($open = fopen(storage_path('app/seed') . "/resort_fee_translations.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $resort_fee_translations[] = [
                    'id' => (int)$data[0],
                    'country_id' => (int)$data[1],
                    'city_id' => (int)$data[2],
                    'language_id' => (int)$data[3],
                    'translation' => $data[4],
                ];
            }

            fclose($open);
        }


        DB::table(ResortFeeTranslation::TABLE_NAME)->insertTs($resort_fee_translations);
    }
}
