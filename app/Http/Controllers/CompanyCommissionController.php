<?php

namespace App\Http\Controllers;

use App\Enums\Level;
use App\Models\Company;
use App\Models\Country;

class CompanyCommissionController extends Controller
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
            ['title' => __('Edit Company Site Commissions')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $bookingCommission = $company->bookingCommission;

        $level1Commissions = $company->saleOfficeCommissions()->whereLevel(Level::First)->get();
        $level1Commissions = $level1Commissions->count() > 0 ? $level1Commissions : [];
        $level1CommissionsCount = $level1Commissions ? $level1Commissions->count() : 1;

        $level2Commissions = $company->saleOfficeCommissions()->whereLevel(Level::Second)->get();
        $level2Commissions = $level2Commissions->count() > 0 ? $level2Commissions : [];
        $level2CommissionsCount = $level2Commissions ? $level2Commissions->count() : 1;

        return view('admin.pages.companies.commissions', compact(
            'breadcrumbs', 'actions', 'company', 'countries', 'bookingCommission',
            'level1Commissions', 'level1CommissionsCount', 'level2Commissions', 'level2CommissionsCount'
        ));
    }
}
