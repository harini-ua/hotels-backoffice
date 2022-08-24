<?php

namespace Database\Seeders;

use App\Models\CompanyPartner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_partners = [];

        if (($open = fopen(storage_path('app/seed') . "/company_partners.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $company_partners[] = [
                    'company_id' => (int)$data[0],
                    'partner_id' => (int)$data[1],
                    'partner_product_id' => (int)$data[2],
                ];
            }
            fclose($open);
        }

        DB::table(CompanyPartner::TABLE_NAME)->insertTs($company_partners);
    }
}
