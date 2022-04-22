<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class HotelDistanceFilters extends Enum
{
    const BARS_PUBS = 'dist_bars_pubs';
    const BEACH = 'dist_beach';
    const BUS_STATION = 'dist_bus_station';
    const CITY_CENTRE = 'dist_city_centre';
    const CROSS_COUNTRY_SKIING = 'dist_cross_country_skiing';
    const FOREST = 'dist_forest';
    const GOLF_COURSE = 'dist_golf_course';
    const LAKE = 'dist_lake';
    const NIGHTCLUBS = 'dist_nightclubs';
    const PARK = 'dist_park';
    const PUBLIC_TRANSPORT = 'dist_public_transport';
    const RESTAURANTS = 'dist_restaurants';
    const RIVER = 'dist_river';
    const SEA = 'dist_sea';
    const SHOPPING = 'dist_shopping';
    const SKI_AREA = 'dist_ski_area';
    const SKI_LIFT = 'dist_ski_lift';
    const STATION = 'dist_station';
    const TOURIST_CENTRE = 'dist_tourist_centre';
    const TRAIN_STATION = 'dist_train_station';

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        if ($value === self::BARS_PUBS) return __('Bars, pubs');
        if ($value === self::BEACH) return __('Beach');
        if ($value === self::BUS_STATION) return __('Bus station');
        if ($value === self::CITY_CENTRE) return __('City centre');
        if ($value === self::CROSS_COUNTRY_SKIING) return __('Cross country skiing');
        if ($value === self::FOREST) return __('Forest');
        if ($value === self::GOLF_COURSE) return __('Golf course');
        if ($value === self::LAKE) return __('Lake');
        if ($value === self::NIGHTCLUBS) return __('Night clubs');
        if ($value === self::PARK) return __('Park');
        if ($value === self::PUBLIC_TRANSPORT) return __('Public transport');
        if ($value === self::RESTAURANTS) return __('Restaurants');
        if ($value === self::RIVER) return __('River');
        if ($value === self::SEA) return __('Sea');
        if ($value === self::SHOPPING) return __('Shopping');
        if ($value === self::SKI_AREA) return __('Ski area');
        if ($value === self::SKI_LIFT) return __('Ski lift');
        if ($value === self::STATION) return __('Station');
        if ($value === self::TOURIST_CENTRE) return __('Tourist centre');
        if ($value === self::TRAIN_STATION) return __('Train Station');

        return parent::getDescription($value);
    }
}
