<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCommissionBookingUpdateRequest;
use App\Http\Requests\CompanyCommissionLevel1UpdateRequest;
use App\Http\Requests\CompanyCommissionLevel2UpdateRequest;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.companies.commissions',
            compact('breadcrumbs', 'actions', 'company', 'countries')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyCommissionLevel1UpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function updateLevel1(CompanyCommissionLevel1UpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            // TODO: Need Implement

            DB::commit();

            alert()->success(__('Success'), __('Commission for Level#1 updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.commissions.edit', $company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyCommissionLevel2UpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function updateLevel2(CompanyCommissionLevel2UpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            // TODO: Need Implement

            DB::commit();

            alert()->success(__('Success'), __('Commission for Level#2 updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.commissions.edit', $company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyCommissionBookingUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function updateBooking(CompanyCommissionBookingUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            // TODO: Need Implement

            DB::commit();

            alert()->success(__('Success'), __('Commission for booking updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.commissions.edit', $company);
    }
}
