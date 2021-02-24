<?php


namespace app\models\star_event;


use DateInterval;
use DateTime;

/**
 * Class EventSession
 * @package app\model
 */
class EventSession
{
    /** @var DateTime  */
    protected DateTime $dateTime;

    /** @var Weather  */
    protected Weather $weather;

    /**
     * EventSession constructor.
     * @param $weather
     * @param int $hour
     * @param int $day
     */
    public function __construct($weather, int $hour, $day = 0)
    {
        $this->weather = $weather;

        $date = date("Y-m-d");
        $this->dateTime = new DateTime("{$date}T{$hour}:00:00");

        if ($day) {
            $this->dateTime->add(new DateInterval("P{$day}D"));
        }
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }
}
