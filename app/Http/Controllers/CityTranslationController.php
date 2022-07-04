<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CityTranslationController extends Controller
{
    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->only(['country', 'language']), [
            'country' => 'sometimes|exists:countries,id',
            'language' => 'sometimes|exists:languages,id',
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        $breadcrumbs = [
            ['title' => __('City Translations')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('City Translations')]
        ];

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $country = null;
        if (\Auth::user()->country_id) {
            $country = Country::find(\Auth::user()->country_id);
        }

        $translations = [];
        if ($request->has(['country', 'language'])) {
            $country = Country::find($request->get('country'));

            $query = City::leftJoin(CityTranslation::TABLE_NAME, function($join) {
                $join->on('cities.id', '=', 'city_translations.city_id');
            });
            $query->where('cities.country_id', $request->get('country'));
            $query->where('city_translations.language_id', $request->get('language'));
            $query->where('cities.active', 1);

            $query->select([
                'city_translations.id AS id',
                'cities.id AS city_id',
                'cities.country_id AS country_id',
                'city_translations.city_name',
                'city_translations.translation'
            ]);

            $translations = $query->get();
        }

        return view('admin.pages.city-translations.index', compact(
            'breadcrumbs', 'countries', 'languages', 'country', 'translations'
        ));
    }
}
