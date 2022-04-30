<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySaleOfficeLevel2CommissionUpdateRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanySaleOfficeLevel2CommissionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param CompanySaleOfficeLevel2CommissionUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanySaleOfficeLevel2CommissionUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            // TODO: Need Implement

            DB::commit();

            alert()->success(__('Success'), __('Commission for sales office level #2 updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.commissions.edit', $company);
    }
}
