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

    /**
     * EventSession constructor.
     * @param DateTime|null $dateTime
     */
    public function __construct(?DateTime $dateTime = null)
    {
        $this->dateTime = new DateTime();

        if ($dateTime) {
            $this->dateTime->setTimestamp($dateTime->getTimestamp());
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
