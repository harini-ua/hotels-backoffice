<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySaleOfficeLevel1CommissionUpdateRequest;
use App\Models\Company;
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

            // TODO: Need Implement

            DB::commit();

            alert()->success(__('Success'), __('Commission for sales office level #1 updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.commissions.edit', $company);
    }
}
