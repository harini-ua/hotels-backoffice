<?php

namespace App\Http\Controllers;

use App\Enums\Level;
use App\Models\City;
use App\Models\CityCommission;
use App\Models\Company;
use App\Models\Country;
use App\Models\CountryCommission;

class CommissionController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Company $company)
    {
        $breadcrumbs = [
            ['title' => __('Edit Commissions')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Commissions')]
        ];

        $cities = City::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $countries = Country::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $citiesCommissions = CityCommission::all();
        $citiesCommissions = $citiesCommissions->count() > 0 ? $citiesCommissions : [];
        $citiesCommissionsCount = $citiesCommissions ? $citiesCommissions->count() : 1;

        $countriesCommissions = CountryCommission::all();
        $countriesCommissions = $countriesCommissions->count() > 0 ? $countriesCommissions : [];
        $countriesCommissionsCount = $countriesCommissions ? $countriesCommissions->count() : 1;

        return view('admin.pages.settings.commissions', compact(
            'breadcrumbs', 'company', 'cities', 'countries',
            'citiesCommissions', 'citiesCommissionsCount', 'countriesCommissions', 'countriesCommissionsCount'
        ));
    }
}
