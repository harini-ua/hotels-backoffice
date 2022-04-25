<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyPrefilledOptionUpdateRequest;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyPrefilledOptionController extends Controller
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
            ['title' => __('Edit Company Prefilled Options')],
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

        $cities = City::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.companies.prefilled-options',
            compact('breadcrumbs', 'actions', 'company', 'countries', 'cities')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyPrefilledOptionUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyPrefilledOptionUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $company->prefilledOption()->update($request->all());

            DB::commit();

            alert()->success(__('Success'), __('Prefilled options updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.prefilled-options.edit');
    }
}
