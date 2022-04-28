<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\CompanyAccountUpdateRequest;
use App\Http\Requests\CompanyContactUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyContactController extends Controller
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
            ['title' => __('Edit Company Site Contact Info')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return view('admin.pages.companies.contact',
            compact('breadcrumbs', 'actions', 'company')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyContactUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyContactUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $company->fill($request->all());
            $company->save();

            DB::commit();

            alert()->success(__('Success'), __('Contact Info has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.contact.edit', $company);
    }
}
