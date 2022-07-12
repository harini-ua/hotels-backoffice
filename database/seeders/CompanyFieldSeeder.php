<?php

namespace Database\Seeders;

use App\Models\CompanyField;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyFieldSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $company_field = [];

        if (($open = fopen(storage_path('app/seed') . "/company_field.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $company_field[] = [
                    'id' => (int)$data[0],
                    'name' => $data[2],
                    'type' => (int)$data[3],
                    'max_length' => (int)$data[4],
                    'is_mobile' => (int)$data[5],
                ];
            }

            fclose($open);
        }

        DB::table(CompanyField::TABLE_NAME)->insertTs($company_field);
    }
}
