<?php


namespace app\models\star_event;


use DomainException;


/**
 * Class WeatherList
 * @package app\model
 */
class WeathersCollection
{

    /** @var Weather[] */
    protected array $list;

    /**
     * WeatherList constructor.
     * @param array $list
     */
    public function __construct(array $list)
    {
        $this->list = array_map(function ($item) {
            return new Weather($item->dt, $item->clouds);
        }, $list);
    }

    /**
     * @param int $timestamp
     * @return Weather
     */
    public function getByTime(int $timestamp): Weather
    {
        var_dump($timestamp);
        foreach ($this->list as $item) {
            if ($item->getDt() === $timestamp) {
                return $item;
            }
        }

        throw new DomainException('Can\'n find weather data for event session by time');
    }

    public function getFirst(): Weather
    {
        return $this->list[0];
    }
}
