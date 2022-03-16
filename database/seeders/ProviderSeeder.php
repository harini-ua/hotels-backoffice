<?php

namespace Database\Seeders;

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
        DB::table('providers')->insertTs(
            [
                [
                    'id' => 1,
                    'name' => 'hotelbed',
                    'email' => 'apitude@hotelbeds.com',
                ],
                [
                    'id' => 2,
                    'name' => 'jactravels',
                    'email' => 'platformsupport@webbeds.com',
                ],
                [
                    'id' => 3,
                    'name' => 'restel',
                    'email' => 'lin.dan@restelhotels.com',
                ],
                [
                    'id' => 4,
                    'name' => 'gta',
                    'email' => null,
                ],
                [
                    'id' => 6,
                    'name' => 'miki',
                    'email' => 'ebzsupport.uk@group-miki.com',
                ],
                [
                    'id' => 7,
                    'name' => 'travco',
                    'email' => 'xmlqueries@travco.co.uk',
                ],
                [
                    'id' => 9,
                    'name' => 'grn',
                    'email' => 'apisupport@grnconnect.com',
                ]
            ]
        );
    }
}
