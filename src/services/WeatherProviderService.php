<?php


namespace app\services;


use app\models\star_event\WeathersCollection;


/**
 * Class WeatherProviderService
 * @package app\services
 */
class WeatherProviderService
{
    protected static string $URL = "api.openweathermap.org/data/2.5/forecast";
    protected string $weatherProviderKey;
    protected string $curlResponse;
    protected string $town;

    public function __construct()
    {
        $iniFile = parse_ini_file(realpath(__DIR__ . "/../../config.ini"), true);
        $this->weatherProviderKey = $iniFile['weatherProvider']['key'];
        $this->curlResponse = '';
    }

    public function fetch(string $town, $force = false): void
    {
        if ($this->curlResponse && $force == false) {
            return;
        }

        $params = [
            'q' => $town, //. ', EE',
            'appid' => $this->weatherProviderKey
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$URL . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $this->curlResponse = curl_exec($ch);
        curl_close($ch);
    }

    public function getWeatherCollection(): WeathersCollection
    {
        return new WeathersCollection((json_decode($this->curlResponse))->list);
    }
}
