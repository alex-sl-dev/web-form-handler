<?php


namespace app\models\town;


use app\models\star_event\EventSessions;
use app\models\star_event\WeathersCollection;
use app\services\WeatherProviderService;

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

    /** @var EventSessions */
    private EventSessions $eventSessions;

    /**
     * Town constructor.
     * @param int $id
     * @param string $town
     */
    public function __construct(int $id, string $town)
    {
        $this->id = $id;
        $this->town = $town;

        $this->eventSessions = new EventSessions();
    }

    /**
     * @return EventSessions
     */
    public function getSunnyEventSessions(): EventSessions
    {
        return $this->eventSessions->getSunnySessions($this);
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
