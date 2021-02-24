<?php


namespace app\services;


use app\models\star_event\WeathersCollection;


/**
 * Class WeatherProviderService
 * @package app\services
 */
class WeatherProviderService
{
    /** @var string */
    protected static string $URL = "api.openweathermap.org/data/2.5/forecast";
    /** @var string */
    protected string $weatherProviderKey;
    /** @var string */
    protected string $curlResponse;
    /** @var string */
    protected string $town;

    /**
     * WeatherProviderService constructor.
     */
    public function __construct()
    {
        $iniFile = parse_ini_file(realpath(__DIR__ . "/../../config.ini"), true);
        $this->weatherProviderKey = $iniFile['weatherProvider']['key'];
    }

    /**
     * @param string $town
     */
    public function fetch(string $town): void
    {
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

    /**
     * @return WeathersCollection
     */
    public function getResponse(): WeathersCollection
    {
        return new WeathersCollection((json_decode($this->curlResponse))->list);
    }
}
