<?php

namespace App\Http\Controllers;

use App\Enums\Level;
use App\Http\Requests\CompanySaleOfficeLevel1CommissionUpdateRequest;
use App\Models\Company;
use App\Models\CompanySaleOfficeCommission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanySaleOfficeLevel1CommissionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param CompanySaleOfficeLevel1CommissionUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanySaleOfficeLevel1CommissionUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $commissions = [];
            foreach ($request->get('level1-commissions') as $commission) {
                $payload = [
                    'level' => Level::First,
                    'company_id' => $company->id
                ];
                $commissions[] = new CompanySaleOfficeCommission(array_merge($commission, $payload));
            }

            $company->saleOfficeCommissions()->whereLevel(Level::First)->delete();
            $company->saleOfficeCommissions()->saveMany($commissions);

            DB::commit();

            alert()->success(__('Success'), __('Commission for sales office level #1 updated has been successful.'));
        } catch (\PDOException $e) {
            dd($e);
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.commissions.edit', $company);
    }
}
