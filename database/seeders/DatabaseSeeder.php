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
        $this->call(EnvironmentSeeder::class);
        $this->call(EnvironmentProviderSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(CityProviderCodeSeeder::class);
        $this->call(HotelSeeder::class);
        $this->call(HotelProviderCodeSeeder::class);
        $this->call(MealPlanSeeder::class);
        $this->call(MealPlanVariantSeeder::class);
        $this->call(FacilitySeeder::class);
        $this->call(FacilityVariantSeeder::class);
        $this->call(HotelFacilitySeeder::class);
        $this->call(HotelImageSeeder::class);
        $this->call(CommissionSeeder::class);
        $this->call(CountryCommissionSeeder::class);
        $this->call(CityCommissionSeeder::class);
        $this->call(HotelCommissionSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(PartnerProductSeeder::class);
        $this->call(PartnerEnvironmentSeeder::class);
        $this->call(CompanySiteDefaultSeeder::class);
//        $this->call(CompanySeeder::class);

        $this->call(RoleAndPermissionSeeder::class);
    }
}
