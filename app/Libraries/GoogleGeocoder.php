<?php

namespace App\Libraries;

class GoogleGeocoder
{
    /**
     * Application's API key
     *
     * @var string $apiKey
     */
    protected $apiKey;

    /**
     * Requested Format
     *
     * @var string $format
     */
    protected $format;

    /**
     * Geocoding request parameters
     *
     * @var [] $param
     */
    protected $param;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Make cURL call
     * @return string
     * @throws \RuntimeException
     */
    protected function call()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/'.$this->format.'?'.$this->param,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FAILONERROR => true,
        ));

        $request = curl_exec($curl);

        curl_close($curl);

        return $request;
    }

    /**
     * Geocoding request
     *
     * @param array $param
     * @param string $format
     *
     * @return string
     */
    public function geocode(array $param, string $format = 'json')
    {
        $this->format = $format;
        $param['key'] = $this->apiKey;
        $this->param = http_build_query($param);

        return $this->call();
    }
}
