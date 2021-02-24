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
    public static string $DEFAULT_FORMAT_DATETIME = "l jS \of F Y h:i:s A";

    /** @var DateTime  */
    protected DateTime $dateTime;

    /** @var Weather  */
    protected Weather $weather;

    /**
     * EventSession constructor.
     * @param Weather $weather
     * @param DateTime $dateTime
     */
    public function __construct(Weather $weather, DateTime $dateTime)
    {
        $this->weather = $weather;
        $this->dateTime = $dateTime;

        /*

        $date = date("Y-m-d");
        $this->dateTime = new DateTime("{$date}T{$hour}:00:00");

        if ($day) {
            $this->dateTime->add(new DateInterval("P{$day}D"));
        }
        */
    }


    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }
}
