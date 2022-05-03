<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryCommissionUpdateRequest;
use App\Models\CountryCommission;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CountryCommissionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param CountryCommissionUpdateRequest $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CountryCommissionUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $commissions = [];

            if ($request->get('countries-commissions')) {
                foreach ($request->get('countries-commissions') as $commission) {
                    $commissions[] = array_merge($commission, ['created_at' => Carbon::now()]);
                }
            }

            CountryCommission::query()->delete();
            CountryCommission::insert($commissions);

            DB::commit();

            alert()->success(__('Success'), __('Country commission updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.commissions.edit');
    }
}
