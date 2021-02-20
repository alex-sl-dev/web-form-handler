<?php


namespace app\models;

use DomainException;

/**
 * Class WeatherList
 * @package app\model
 */
class WeatherList
{
    /** @var Weather[] */
    protected array $list;

    /**
     * WeatherList constructor.
     * @param array $list
     */
    public function __construct(array $list)
    {
        $this->list = array_map(function ($item){
            return new Weather($item->dt, $item->clouds);
        }, $list);
    }

    /**
     * @param int $timestamp
     * @return Weather
     */
    public function getByTime(int $timestamp): Weather
    {
        foreach ($this->list as $item) {
            if ($item->getDt() === $timestamp) {
                return $item;
            }
        }

        throw new DomainException('Can\'n find weather data for event session by time');
    }
}
