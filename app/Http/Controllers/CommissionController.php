<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\Country;

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

        $countries = Country::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $cities = City::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.settings.commissions', compact(
            'breadcrumbs', 'company', 'countries', 'cities',
        ));
    }
}
