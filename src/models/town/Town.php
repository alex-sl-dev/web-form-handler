<?php


namespace app\models\town;


use app\models\star_event\EventSessions;
use app\models\star_event\WeathersCollection;

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
    }

    /**
     * @return EventSessions
     */
    public function getEventSessions(): EventSessions
    {
        return $this->eventSessions;
    }

    /**
     * @param WeathersCollection $weatherList
     */
    public function initializeEventSessions(WeathersCollection $weatherList)
    {
        $this->eventSessions = EventSessions::createFutureSessions($weatherList);
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
