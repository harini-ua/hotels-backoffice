<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProviderSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(EnvironmentSeeder::class);
        $this->call(ProviderEnvironmentSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(CityProviderCodeSeeder::class);
        $this->call(HotelSeeder::class);
//        $this->call(FacilitySeeder::class);
//        $this->call(FacilityVariantSeeder::class);
//        $this->call(HotelFacilitySeeder::class);
        $this->call(HotelImageSeeder::class);
    }
}
