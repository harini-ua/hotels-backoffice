<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;

class IndexService
{
    /**
     * @param City|Country $model
     * @param bool $index
     * @return void
     */
    public function change($model, bool $index = true)
    {
        switch (true) {
            case $model instanceof Country:
                $this->country($model, $index);
                break;
            case $model instanceof City:
                $this->city($model, $index);
                break;
            case $model instanceof Hotel:
                $this->hotel($model, $index);
                break;
        }
    }

    /**
     * Add or remove index all city and hotels by country
     *
     * @param Country $country
     * @param bool $index
     * @return void
     */
    protected function country(Country $country, bool $index = true)
    {
        $cities = $country->load('cities');

        foreach ($cities as $city) {
            if ($index) {
                // TODO: Need Implement add to index
            } else {
                // TODO: Need Implement remove to index
            }
        }
    }

    /**
     * Add or remove index city and hotels
     *
     * @param City $city
     * @param bool $index
     * @return void
     */
    protected function city(City $city, bool $index = true)
    {
        if ($index) {
            // TODO: Need Implement add to index
        } else {
            // TODO: Need Implement remove to index
        }
    }

    /**
     * Add or remove index hotel
     *
     * @param Hotel $hotel
     * @param bool $index
     * @return void
     */
    protected function hotel(Hotel $hotel, bool $index = true)
    {
        if ($index) {
            // TODO: Need Implement add to index
        } else {
            // TODO: Need Implement remove to index
        }
    }
}
