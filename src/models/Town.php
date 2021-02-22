<?php


namespace app\models;


/**
 * Class Town
 * @package app\model
 */
class Town
{
    /** @var string */
    private string $town;
    /** @var int */
    private int $id;

    /**
     * @var EventSessionList
     */
    private EventSessionList $eventSessions;

    /**
     * Town constructor.
     * @param int $id
     * @param string $town
     */
    public function __construct(int $id, string $town)
    {
        $this->id = $id;
        $this->town = $town;
    }

    /**
     * @return EventSessionList
     */
    public function getEventSessions(): EventSessionList
    {
        return $this->eventSessions;
    }

    /**
     * @param WeatherList $weatherList
     */
    public function setWeatherForEventSession(WeatherList $weatherList)
    {
        $this->eventSessions = EventSessionList::createFutureSessions($weatherList);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTown(): string
    {
        return $this->town;
    }
}
