<?php

namespace App\Http\Controllers;

use App\Enums\AccessCodeType;
use App\Http\Requests\CompanyGeneralUpdateRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyGeneralController extends Controller
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
            ['title' => __('Edit Company Site General')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $user = $company->employee;

        $accessCode = null;
        if ((int) $company->login_type === AccessCodeType::FIXED) {
            $accessCode = $company->accessCodes()->first();
        }

        return view('admin.pages.companies.general',
            compact('breadcrumbs', 'actions', 'company', 'user', 'accessCode')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyGeneralUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyGeneralUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $company->fill($request->except(['sub_companies']));
            $company->sub_companies = $request->has('sub_companies');
            $company->save();

            DB::commit();

            alert()->success(__('Success'), __('Company updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.general.edit', $company);
    }
}
