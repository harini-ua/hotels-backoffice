<?php

namespace Database\Seeders;

use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table(Provider::TABLE_NAME)->insertTs(
            [
                [
                    'id' => 1,
                    'name' => 'hotelbed',
                    'email' => 'apitude@hotelbeds.com',
                    'support_phone' => '+34 871 180 153',
                ],
                [
                    'id' => 2,
                    'name' => 'jactravels',
                    'email' => 'platformsupport@webbeds.com',
                    'support_phone' => '+44 20 30 96 52 21',
                ],
                [
                    'id' => 3,
                    'name' => 'restel',
                    'email' => 'lin.dan@restelhotels.com',
                    'support_phone' => '+34 91 736 50 40',
                ],
                [
                    'id' => 4,
                    'name' => 'gta',
                    'email' => null,
                    'support_phone' => '+34 871 180 153',
                ],
                [
                    'id' => 6,
                    'name' => 'miki',
                    'email' => 'ebzsupport.uk@group-miki.com',
                    'support_phone' => '+44 20 75 07 50 86',
                ],
                [
                    'id' => 7,
                    'name' => 'travco',
                    'email' => 'xmlqueries@travco.co.uk',
                    'support_phone' => '+44 20 78 64 60 41',
                ],
                [
                    'id' => 9,
                    'name' => 'grn',
                    'email' => 'apisupport@grnconnect.com',
                    'support_phone' => '+91-9720359689',
                ]
            ]
        );
    }
}
