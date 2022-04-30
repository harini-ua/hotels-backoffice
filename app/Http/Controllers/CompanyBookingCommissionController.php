<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyBookingCommissionUpdateRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CompanyBookingCommissionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param CompanyBookingCommissionUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyBookingCommissionUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $company->bookingCommission()
                ->updateOrCreate(
                    [ 'company_id' => $company->id ],
                    [
                        'standard_commission' => $request->get('standard_commission'),
                        'booking_commission' => $request->get('booking_commission'),
                        'payback_to_client' => $request->get('payback_to_client'),
                        'minimal_commission' => $request->get('minimal_commission'),
                        'use_minimal_commission' => $request->has('use_minimal_commission'),
                    ],
                );

            DB::commit();

            alert()->success(__('Success'), __('Company booking commission updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.commissions.edit', $company);
    }
}
