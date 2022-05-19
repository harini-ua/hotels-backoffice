<?php

namespace App\Jobs;

use App\Libraries\GoogleGeocoder;
use App\Models\Country;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Routing\Annotation\Route;

class UpdateLatLongCities implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The country instance.
     *
     * @var \App\Models\Country
     */
    protected $country;

    /** @var GoogleGeocoder $googleGeocoder */
    protected $googleGeocoder;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Country $country, $apiKey)
    {
        $this->country = $country;
        $this->googleGeocoder = new GoogleGeocoder($apiKey);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \JsonException
     */
    public function handle()
    {
        $cities = $this->country->sities;
        foreach ($cities as $city) {
            $city_name = str_replace([" ", ','], ['', '+'], $city->name);
            $country_name = str_replace(" ", '', $this->country->name);

            $params = [
                'address' => $city_name . '+' . $country_name
            ];

            $result = $this->googleGeocoder->geocode($params);

            $result = json_decode($result, true, 512, JSON_THROW_ON_ERROR);

            if (!empty($result) && $result['results']) {
                $latitude = $result['results'][0]['geometry']['location']['lat'];
                $longitude = $result['results'][0]['geometry']['location']['lng'];

                $city->update([
                    'position' => new Point($latitude, $longitude)
                ]);
            }
        }
    }
}
