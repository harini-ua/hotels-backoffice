<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyVatUpdateRequest;
use App\Models\Company;
use App\Models\CompanyVat;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyVatController extends Controller
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
            ['title' => __('Edit Company Site VAT')],
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

        $vat = $company->vats->count() > 0 ? $company->vats : [];
        $count = $company->vats->count() > 0 ? $company->vats->count() : 1;

        return view('admin.pages.companies.vat',
            compact('breadcrumbs', 'actions', 'company', 'countries', 'vat', 'count')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyVatUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyVatUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $vat = [];
            foreach ($request->get('vat') as $item) {
                $vat[] = new CompanyVat($item);
            }
            $company->vats()->delete();
            $company->vats()->saveMany($vat);

            DB::commit();

            alert()->success(__('Success'), __('Company VAT updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.vat.edit', $company);
    }
}
