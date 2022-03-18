<?php

namespace App\Libraries;

/**
 * IPInfoDB API service.
 */
class IPInfoDB
{
    /**
     * IPInfoDB API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Constructor.
     *
     * @param string $apiKey
     *
     * @throws \Exception
     */
    public function __construct($apiKey = null)
    {
        if ($apiKey == null) {
            $this->apiKey = env('IPINFODB_API_KEY');
        }

        if (!preg_match('/^[0-9a-z]{64}$/', $apiKey)) {
            throw new \Exception(__CLASS__ . __(': Invalid IPInfoDB API key.'));
        }

        $this->apiKey = $apiKey;
    }

    /**
     * Get country information by IP address.
     *
     * @param string $ip
     *
     * @return array|false
     */
    public function getCountry($ip)
    {
        $url = 'https://api.ipinfodb.com/v3/ip-country';

        $params = [
            'key'    => $this->apiKey,
            'format' => 'json',
            'ip'     => $ip,
        ];

        $response = $this->get($url . '?' . http_build_query($params));

        if (($json = json_decode($response, true)) === null) {
            return false;
        }

        return $json;
    }

    /**
     * Get city information by IP address.
     *
     * @param string $ip
     *
     * @return array|false
     */
    public function getCity(string $ip)
    {
        $url = 'https://api.ipinfodb.com/v3/ip-city';

        $params = [
            'key'    => $this->apiKey,
            'format' => 'json',
            'ip'     => $ip,
        ];

        $response = $this->get($url . '?' . http_build_query($params));

        if (($json = json_decode($response, true)) === null) {
            return false;
        }

        return $json;
    }

    /**
     * Call a remote URL using cUrl GET request.
     *
     * @param string $url
     *
     * @return string|null
     */
    private function get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);

        if (!curl_errno($ch)) {
            curl_close($ch);

            return $response;
        }

        curl_close($ch);

        return null;
    }
}
