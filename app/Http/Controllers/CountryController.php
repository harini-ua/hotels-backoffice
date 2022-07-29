<?php

namespace App\Http\Controllers;

use App\DataTables\CountriesDataTable;
use App\DataTables\ProvidersDataTable;
use App\Http\Requests\CountryUpdateRequest;
use App\Libraries\GoogleGeocoder;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            ['link' => route('settings.index'), 'name' => __('Settings')],
            ['name' => __('All Countries')]
        ];

        $regions = DB::table(Country::TABLE_NAME)
            ->groupBy('region')
            ->pluck('region', 'region');

        $currencies = Currency::all()
            ->sortBy('code')
            ->pluck('code', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return $dataTable->render('admin.pages.countries.index', compact(
            'breadcrumbs',
            'regions',
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
            ['link' => route('settings.index'), 'name' => __('Settings')],
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

            if ($country->isDirty('active')) {
                // Change blacklist status for all cities in countries
                $country->cities()->update([
                    'blacklisted' => $request->has('active')
                ]);
            }

            DB::commit();

            alert()->success($country->name, __('Country updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('countries.index');
    }

    /**
     * @param Request $request
     * @param Country $country
     * @return JsonResponse
     * @throws \JsonException
     */
    public function updateLocations(Request $request, Country $country)
    {
        $cities = $country->cities;


        $success = $errors = 0;
        $response = [];

        $google = new GoogleGeocoder($request->get('google_api_key'));

        // TODO: Need test valid api key

        foreach ($cities as $city) {
            $city_name = str_replace([" ", ','], ['', '+'], $city->name);
            $country_name = str_replace(" ", '', $country->name);

            $params = [
                'address' => $city_name . '+' . $country_name
            ];

            $result = $google->geocode($params);
            $result = json_decode($result, true, 512, JSON_THROW_ON_ERROR);

            if (!empty($result) && !empty($result['results'])) {
                $latitude = $result['results'][0]['geometry']['location']['lat'];
                $longitude = $result['results'][0]['geometry']['location']['lng'];

                $city->update([
                    'position' => new Point($latitude, $longitude)
                ]);

                ++$success;
            } else {
                ++$errors;

                $response['debug'][] = [
                    'id' => $city->id,
                    'name' => $city->name,
                    'message' => "Doesn't get location, please update manually."
                ];
            }
        }

        $response['total']['status'] = $success > 0 ? 'success' : 'warning';
        $response['total']['message'] = implode( ' ', [
            '<strong>'.$success.'</strong>',
            'out of',
            '<strong>'.($success + $errors).'</strong>',
            Str::plural('city', $success),
            'location upgraded.'
        ]);

        return response()->json($response);
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
