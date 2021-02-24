<?php


namespace app\models\star_event;


use Countable;
use DateInterval;
use DateTime;
use Iterator;
use JsonSerializable;


/**
 * Class EventSessions
 * @package app\model
 */
class EventSessions implements iterator, countable, JsonSerializable
{
    use CountableIteratorItemsTrait;

    /** @var array|int[] */
    private static array $EVENT_HOURS = [14, 17, 20, 23];

    /**
     * @param WeathersCollection $weatherList
     * @param bool $ignoreWeather
     * @return EventSessions
     */
    public static function createFutureSessions(
        WeathersCollection $weatherList,
        bool $ignoreWeather = false
    ): EventSessions
    {
        $instance = new self();

        for ($day = 0; $day < 5; $day++) {
            foreach (EventSessions::$EVENT_HOURS as $hour) {
                $time = mktime($hour, null, null,
                    (new DateTime())->format('n'),
                    (new DateTime())->add(new DateInterval('P1D'))->format('j'),
                    (new DateTime())->format('Y'),
                );
                $weather = $weatherList->getByTime($time);
                if ($weather->getCloud()->all < 20 || $ignoreWeather) {
                    $instance->items[] = new EventSession(
                        $weather,
                        (new DateTime('now'))->setTimestamp($time)
                    );
                }
            }
        }

        return $instance;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $response = [];

        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                /** @var EventSession $item */
                $response[] = [
                    'dt' => $item->getDateTime()->getTimestamp(),
                    'label' => $item->getDateTime()->format(EventSession::$DEFAULT_FORMAT_DATETIME),
                ];
            }
        }

        if (empty($response)) {
            throw new DomainCreationException("Can't serialise:" . __CLASS__);
        }

        return $response;
    }
}
