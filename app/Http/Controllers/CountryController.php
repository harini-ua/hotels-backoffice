<?php

namespace App\Http\Controllers;

use App\Models\Country;

class CountryController extends Controller
{
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
