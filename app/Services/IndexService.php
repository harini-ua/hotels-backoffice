<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;

class IndexService
{
    /**
     * @param Country|City|Hotel $model
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
            $this->city($city, $index);
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
            $city->searchable();
        } else {
            $city->unsearchable();
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
            $hotel->searchable();
        } else {
            $hotel->unsearchable();
        }
    }
}
