<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityCommissionUpdateRequest;
use App\Models\CityCommission;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CityCommissionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param CityCommissionUpdateRequest $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CityCommissionUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $commissions = [];

            if ($request->get('cities-commissions')) {
                foreach ($request->get('cities-commissions') as $commission) {
                    $commissions[] = array_merge($commission, ['created_at' => Carbon::now()]);
                }
            }

            CityCommission::query()->delete();
            CityCommission::insert($commissions);

            DB::commit();

            alert()->success(__('Success'), __('City commission updated has been successful.'));
        } catch (\PDOException $e) {
            dd($e);
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('settings.commissions.edit');
    }
}
