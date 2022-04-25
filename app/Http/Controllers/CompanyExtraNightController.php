<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyExtraNightUpdateRequest;
use App\Models\Company;
use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyExtraNightController extends Controller
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
            ['title' => __('Edit Company Extra Night')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $extraNight = $company->extraNight;

        $currencies = Currency::all()
            ->sortBy('code')
            ->pluck('code', 'id');

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return view('admin.pages.companies.extra-nights',
            compact('breadcrumbs', 'actions', 'company', 'extraNight', 'currencies')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyExtraNightUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyExtraNightUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $company->extraNight()
                ->updateOrCreate(
                    [ 'company_id' => $company->id ],
                    [
                        'enable' => $request->has('enable'),
                        'partner_price' => $request->get('partner_price'),
                        'customer_price' => $request->get('customer_price'),
                        'currency_id' => $request->get('currency_id'),
                    ],
                );

            DB::commit();

            alert()->success(__('Success'), __('Extra night updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.extra-nights.edit', $company);
    }
}
