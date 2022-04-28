<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCustomerSupportUpdateRequest;
use App\Models\Company;
use App\Models\CompanySupport;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyCustomerSupportController extends Controller
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
            ['title' => __('Edit Company Site Customer Supports')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $supports = $company->supports->count() > 0 ? $company->supports : [];
        $count = $company->supports->count() > 0 ? $company->supports->count() : 1;

        $countries = Country::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.companies.customer-supports',
            compact('breadcrumbs', 'actions', 'company', 'countries', 'supports', 'count')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyCustomerSupportUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyCustomerSupportUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $supports = [];
            foreach ($request->get('supports') as $support) {
                $supports[] = new CompanySupport($support);
            }
            $company->supports()->delete();
            $company->supports()->saveMany($supports);

            DB::commit();

            alert()->success(__('Success'), __('Customer support updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.customer-supports.edit', $company);
    }
}
