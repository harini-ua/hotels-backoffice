<?php

namespace App\Http\Controllers;

use App\DataTables\CitiesDataTable;
use App\DataTables\ProvidersDataTable;
use App\Http\Requests\CityUpdateRequest;
use App\Models\City;
use App\Models\Country;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.cities.update', compact(
            'breadcrumbs', 'city', 'countries'
        ));
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

            $city->fill($request->except('position'));
            $city->active = $request->has('active');
            $city->blacklisted = $request->has('blacklisted');

            if ($request->filled('position')) {
                $location = explode(',', $request->get('position'));
                $city->position = new Point($location[0], $location[1]);
            }

            $saved = $city->save();

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
     * @param Request $request
     * @param City  $city
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateAjax(Request $request, City $city)
    {
        $city->fill($request->all());

        $saved = $city->save();

        return response()->json([
            'success' => $saved
        ]);
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
