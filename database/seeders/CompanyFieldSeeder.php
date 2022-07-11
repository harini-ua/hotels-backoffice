<?php

namespace Database\Seeders;

use App\Enums\FieldType;
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
        DB::table(CompanyField::TABLE_NAME)->insertTs([
            'name' => 'Welcome Email',
            'type' => FieldType::HTML,
            'max_length' => 0,
        ]);
    }
}
