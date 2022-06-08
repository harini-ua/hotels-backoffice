<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCompaniesUpdateRequest;
use App\Models\Company;
use App\Models\SubCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SubCompaniesController extends Controller
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
            ['title' => __('Edit Sub Companies')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $subCompanies = $company->subCompanies->count() > 0 ? $company->subCompanies : [];
        $count = $company->subCompanies->count() > 0 ? $company->subCompanies->count() : 1;

        return view('admin.pages.companies.sub-companies', compact(
            'breadcrumbs', 'actions', 'company', 'subCompanies', 'count'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubCompaniesUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(SubCompaniesUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $subCompanies = $request->get('sub-companies');

            $subCompaniesIds = $company->subCompanies->pluck('id')->toArray();
            $deletedSubCompaniesIds = array_diff($subCompaniesIds, array_column($subCompanies, 'id'));
            SubCompany::whereIn('id', $deletedSubCompaniesIds)->delete();

            foreach ($subCompanies as $item) {
                // Update sub company
                if (isset($item['id'])) {
                    $subCompany = SubCompany::find($item['id']);
                }
                // Create new sub company
                else {
                    $subCompany = new SubCompany();
                    $subCompany->company_id = $company->id;
                }
            }

            $subCompany->fill($item);

            if($subCompany->isDirty()){
                $subCompany->save();
            }

            DB::commit();

            alert()->success(__('Success'), __('Sub Companies updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.sub-companies.edit', $company);
    }
}
