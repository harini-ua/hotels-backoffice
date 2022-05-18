<?php

namespace App\Http\Controllers;

use App\DataTables\ProvidersDataTable;
use App\Http\Requests\ProviderUpdateRequest;
use App\Models\Country;
use App\Models\Provider;
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
    public function index(ProvidersDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Providers')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('All Providers')]
        ];

        $countries = Country::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return $dataTable->render('admin.pages.providers.index', compact(
            'breadcrumbs', 'countries'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Provider $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Provider $provider)
    {
        $breadcrumbs = [
            ['title' => __('Edit Provider')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('providers.index'), 'name' => __('All Providers')],
            ['name' => $provider->name]
        ];

        return view('admin.pages.providers.update', compact('breadcrumbs', 'provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProviderUpdateRequest $request
     * @param Provider $provider
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(ProviderUpdateRequest $request, Provider $provider)
    {
        try {
            DB::beginTransaction();

            $provider->fill($request->all());
            $provider->active = $request->has('active');
            $provider->save();

            DB::commit();

            alert()->success($provider->name, __('Provider updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('providers.index');
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
