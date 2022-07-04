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
        $this->call(CountryCommissionSeeder::class);
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
        $this->call(PartnerSeeder::class);
        $this->call(PartnerProductSeeder::class);
        $this->call(PartnerEnvironmentSeeder::class);
        $this->call(CompanyThemeSeeder::class);
        $this->call(DefaultContentSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DistributorSeeder::class);
        $this->call(DistributorUserSeeder::class);
        $this->call(DistributorCountrySeeder::class);
        $this->call(DistributorLanguageSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(SubCompanySeeder::class);
        $this->call(BookingUserSeeder::class);
        $this->call(DiscountVoucherSeeder::class);
        $this->call(DiscountVoucherCodeSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(BookingGuestSeeder::class);
        $this->call(HotelDistanceSeeder::class);
        $this->call(CompanyExtraNightSeeder::class);
        $this->call(CompanyPartnerSeeder::class);
        $this->call(CompanyBookingCommissionSeeder::class);
        $this->call(CompanyHomepageOptionSeeder::class);
        $this->call(CountryCurrencyRateSeeder::class);
        $this->call(DistributorBookingCommissionSeeder::class);
        $this->call(CompanySaleOfficeCommissionSeeder::class);
        $this->call(CityTranslationSeeder::class);
    }
}
