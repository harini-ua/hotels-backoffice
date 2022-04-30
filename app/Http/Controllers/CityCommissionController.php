<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityCommissionUpdateRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CityCommissionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param CityCommissionUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CityCommissionUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            // TODO: Need Implement

            DB::commit();

            alert()->success(__('Success'), __('City commission updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('commissions.edit', $company);
    }
}