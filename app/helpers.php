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

        return $default;
    }
}

if (!function_exists('textClass')) {
    function textClass($status, $last_message)
    {
        // change text color based on the last message
        if ($last_message === 'is running') {
            return ($status === 'success') ? 'text-success' : 'text-danger';
        }

        return ($status === 'failed') ? 'text-danger' : '';
    }
}

if (!function_exists('onlyEnabled')) {
    function onlyEnabled($collection)
    { // filter the collection to only the one's which are enabled
        return $collection->filter(function ($item) {
            return $item->enabled == 1;
        });
    }
}

if (!function_exists('minValue')) {
    function minValue($checks)
    { // used for returning the oldest last_ran_at date
        return min(array_column($checks->toArray(), 'last_ran_at'));
    }
}

if (!function_exists('numberTextClass')) {
    function numberTextClass($type, $status, $text)
    { // change text color based on the threshold value
        // these maps to the treshold configs in the config/server-monitor.php`
        $configs = [
            'diskspace' => 'server-monitor.diskspace_percentage_threshold',
            'cpu' => 'server-monitor.cpu_usage_threshold',
            'memory' => 'server-monitor.memory_usage_threshold'
        ];

        preg_match('/(\d+)/', $text, $pieces); // get all the numbers in the text

        if (!empty($pieces)) {
            $number = (float)$pieces[0];
            $config = config($configs[$type]);

            // determine the class to add based on the current percentage value
            return ($number >= $config['fail']) ? 'text-danger' : (($number >= $config['warning']) ? 'text-warning' : '');
        }

        // for the one's whose value isn't percentage based
        return textClass($status, $text);
    }
}
