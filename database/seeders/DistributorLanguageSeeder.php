<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distributor_languages = [];
        if (($open = fopen(storage_path('app/seed') . "/distributors.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $languages = array_filter(explode(',', trim($data[7])));
                if(!empty($languages)) {
                    $languages_ids = DB::table('languages')
                        ->select('id')
                        ->whereIn('name', array_values($languages))
                        ->get();
                    if (!empty($languages_ids)) {
                        foreach ($languages_ids as $language_id) {
                            $distributor_languages[] = [
                                'distributor_id' => (int)$data[0],
                                'language_id' => $language_id->id,
                            ];
                        }
                    }
                }

            }

            fclose($open);
        }

        foreach (array_chunk($distributor_languages, 1000) as $distributor_languages_data) {
            DB::table('distributor_language')->insertTs($distributor_languages_data);
        }
    }
}
