<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityProviderController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  City  $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(City $city)
    {
        $breadcrumbs = [
            ['title' => __('Edit City')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.index'), 'name' => __('Settings')],
            ['link' => route('cities.index'), 'name' => __('All Cities')],
            ['name' => $city->name]
        ];

        $city->load('providers');

        return view('admin.pages.cities-providers.update', compact(
            'breadcrumbs', 'city'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param City  $city
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request, City $city)
    {
        try {
            DB::beginTransaction();

            // TODO: Need Implement

            DB::commit();

            alert()->success($city->name, __('City Providers updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('hotels.providers.update', $hotel);
    }
}
