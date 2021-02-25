<?php


namespace app\models\town;


use app\models\star_event\EventSessions;


class Town
{
    private string $town;
    private int $id;
    private EventSessions $eventSessions;

    public function __construct(int $id, string $town)
    {
        $this->id = $id;
        $this->town = $town;

        $this->eventSessions = new EventSessions();
    }

    public function getSunnyEventSessions(): EventSessions
    {
        return $this->eventSessions->getSunnySessions($this);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTown(): string
    {
        return $this->town;
    }
}
