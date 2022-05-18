<?php

namespace App\Http\Controllers;

use App\DataTables\CitiesDataTable;
use App\DataTables\ProvidersDataTable;
use App\Http\Requests\CityUpdateRequest;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProvidersDataTable $dataTable
     * @return mixed
     */
    public function index(CitiesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Cities')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('settings.index'), 'name' => __('Settings')],
            ['name' => __('All Cities')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return $dataTable->render('admin.pages.cities.index', compact(
            'breadcrumbs', 'countries'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param City $city
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

        return view('admin.pages.cities.update', compact('breadcrumbs', 'city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityUpdateRequest $request
     * @param City $city
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CityUpdateRequest $request, City $city)
    {
        try {
            DB::beginTransaction();

            $city->fill($request->all());
            $city->active = $request->has('active');
            $city->save();

            DB::commit();

            alert()->success($city->name, __('City updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('cities.index');
    }

    /**
     * @param City $city
     * @return JsonResponse
     * @throws \Exception
     */
    public function active(City $city)
    {
        $city->active = !$city->active;
        $city->save();

        return response()->json(['success' => true]);
    }

    /**
     * Get all hotels by city
     *
     * @param City $city
     * @return array
     */
    public function hotels(City $city)
    {
        $hotels = $city->hotels
            ->sortBy('name')
            ->map(static function ($hotel) {
                return [
                    'id' => $hotel->id,
                    'name' => $hotel->name,
                ];
            });

        $default = $hotels->count() ? __('- Choose Hotel -') : __('No Available Hotels');
        $hotels->prepend(['id' => '', 'name' => $default]);

        return $hotels;
    }
}
