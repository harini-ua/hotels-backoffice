<?php

use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('providers')->insert(
            [
                [
                    'id' => 1,
                    'provider_name' => 'hotelbed',
                    'email' => 'apitude@hotelbeds.com'
                ],
                [
                    'id' => 2,
                    'provider_name' => 'jactravels',
                    'email' => 'platformsupport@webbeds.com'
                ],
                [
                    'id' => 3,
                    'provider_name' => 'restel',
                    'email' => 'lin.dan@restelhotels.com'
                ],
                [
                    'id' => 4,
                    'provider_name' => 'gta',
                    'email' => ''
                ],
                [
                    'id' => 6,
                    'provider_name' => 'miki',
                    'email' => 'ebzsupport.uk@group-miki.com'
                ],
                [
                    'id' => 7,
                    'provider_name' => 'travco',
                    'email' => 'xmlqueries@travco.co.uk'
                ],
                [
                    'id' => 9,
                    'provider_name' => 'grn',
                    'email' => 'apisupport@grnconnect.com'
                ]

            ]
        );
    }
}
