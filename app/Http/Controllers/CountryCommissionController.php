<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryCommissionUpdateRequest;
use App\Models\Company;
use App\Models\CountryCommission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CountryCommissionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param CountryCommissionUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CountryCommissionUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $commissions = [];
            foreach ($request->get('countries-commissions') as $commission) {
                $commissions[] = new CountryCommission($commission);
            }

            $company->countryCommissions()->delete();
            $company->countryCommissions()->saveMany($commissions);

            DB::commit();

            alert()->success(__('Success'), __('Country commission updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('commissions.edit', $company);
    }
}
