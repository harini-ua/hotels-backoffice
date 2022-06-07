<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyOthersUpdateRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyOthersController extends Controller
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
            ['title' => __('Edit Company Site Options')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $mainOptions = $company->mainOptions;

        return view('admin.pages.companies.others',
            compact('breadcrumbs', 'actions', 'company', 'mainOptions')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyOthersUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyOthersUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $company->mainOptions()->update([
                'sub_companies' => $request->has('sub_companies'),
                'chat_enabled' => $request->has('chat_enabled'),
                'chat_script' => $request->get('chat_script'),
                'adobe_enabled' => $request->has('adobe_enabled'),
                'adobe_script' => $request->get('adobe_script'),
            ]);

            DB::commit();

            alert()->success(__('Success'), __('Company options updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.others.edit', $company);
    }
}
