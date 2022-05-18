<?php

namespace App\Http\Controllers;

use App\DataTables\CountriesDataTable;
use App\DataTables\ProvidersDataTable;
use App\Http\Requests\CountryUpdateRequest;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProvidersDataTable $dataTable
     * @return mixed
     */
    public function index(CountriesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Countries')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Countries')]
        ];

        $currencies = Currency::all()
            ->sortBy('code')
            ->pluck('code', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return $dataTable->render('admin.pages.countries.index', compact(
            'breadcrumbs',
            'currencies',
            'languages'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Country $country
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Country $country)
    {
        $breadcrumbs = [
            ['title' => __('Edit Country')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('countries.index'), 'name' => __('All Countries')],
            ['name' => $country->name]
        ];

        $currencies = Currency::all()
            ->sortBy('code')
            ->pluck('code', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.countries.update', compact(
            'breadcrumbs',
            'country',
            'currencies',
            'languages'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CountryUpdateRequest $request
     * @param Country $country
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CountryUpdateRequest $request, Country $country)
    {
        try {
            DB::beginTransaction();

            $country->fill($request->all());
            $country->active = $request->has('active');
            $country->save();

            DB::commit();

            alert()->success($country->name, __('Country updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('countries.index');
    }

    /**
     * @param Country $country
     * @return JsonResponse
     * @throws \Exception
     */
    public function active(Country $country)
    {
        $country->active = !$country->active;
        $country->save();

        return response()->json(['success' => true]);
    }

    /**
     * Get all cities by country
     *
     * @param Country $country
     * @return array
     */
    public function cities(Country $country)
    {
        $cities = $country->cities
            ->sortBy('name')
            ->map(static function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name,
                ];
            });

        $default = $cities->count() ? __('- Choose City -') : __('No Available Cities');
        $cities->prepend(['id' => '', 'name' => $default]);

        return $cities;
    }
}
