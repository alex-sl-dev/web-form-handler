<?php


namespace app\models;


use DateInterval;
use DateTime;

/**
 * Class EventSession
 * @package app\model
 */
class EventSession
{
    /** @var DateTime  */
    protected DateTime $startTime;

    /** @var int  */
    protected int $day;

    /** @var Weather  */
    protected Weather $weather;

    /**
     * EventSession constructor.
     * @param $weather
     * @param int $startTime
     * @param int $day
     */
    public function __construct($weather, int $startTime, $day = 0)
    {
        $this->weather = $weather;


        // a bit ugly
        $date = date("Y-m-d");
        $this->startTime = new DateTime("{$date}T{$startTime}:00:00");

        $this->day = $day;

        if ($day) {
            $this->startTime->add(new DateInterval("P{$day}D"));
        }
    }

    /**
     * @return DateTime
     */
    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }
}
