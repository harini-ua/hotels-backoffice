<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyHomepageUpdateRequest;
use App\Models\Company;
use App\Models\CompanyTheme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyHomepageController extends Controller
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
            ['title' => __('Edit Company Site Homepage')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $company->load(['homepageOptions']);

        $themes = CompanyTheme::all()
            ->sortBy('theme_name')
            ->pluck('theme_name', 'id');

        return view('admin.pages.companies.homepage',
            compact('breadcrumbs', 'actions', 'company', 'themes')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyHomepageUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyHomepageUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $company->homepageOptions()->update([]);

            DB::commit();

            alert()->success(__('Success'), __('Homepage updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.homepage.edit');
    }
}
