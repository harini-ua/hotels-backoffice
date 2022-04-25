<?php

if (!function_exists('generateDiscountCodes')) {
    function generateDiscountCodes($length = 11)
    {
        return substr(md5(\Carbon\Carbon::now()->timestamp . randomStrings(10)), 0, $length);
    }
}

if (!function_exists('randomStrings')) {
    function randomStrings($length = 32)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle($str_result), 0, $length);
    }
}

if (!function_exists('setDefaultHotelDistancesFilters')) {
    function setDefaultHotelDistancesFilters()
    {
        $filters = [
            'dist_bars_pubs',
            'dist_beach',
            'dist_bus_station',
            'dist_city_centre',
            'dist_cross_country_skiing',
            'dist_forest',
            'dist_golf_course',
            'dist_lake',
            'dist_nightclubs',
            'dist_park',
            'dist_public_transport',
            'dist_restaurants',
            'dist_river',
            'dist_sea',
            'dist_shopping',
            'dist_ski_area',
            'dist_ski_lift',
            'dist_station',
            'dist_tourist_centre',
            'dist_train_station',
        ];

        $default = [];
        foreach ($filters as $filter) {
            $default[] = [
                "name" => $filter,
                "value" => "",
                "status" => 1
            ];
        }

        return json_encode($default, JSON_THROW_ON_ERROR);
    }
}
