<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
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
