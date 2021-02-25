<?php


namespace app\models\star_event;


use app\models\town\Town;
use app\services\WeatherProviderService;
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
     * @param Town $town
     * @return EventSessions
     */
    public function __constructor(
        Town $town
    ): EventSessions
    {

        $weatherProvider = new WeatherProviderService();
        $weatherProvider->fetch($town->getTown());
        $weatherList = $weatherProvider->getWeatherCollection();

        for ($day = 0; $day < 5; $day++) {
            foreach (EventSessions::$EVENT_HOURS as $hour) {
                $offsetTime = mktime($hour, null, null,
                    (new DateTime())->format('n'),
                    (new DateTime())->add(new DateInterval("P{$day}D"))->format('j'),
                    (new DateTime())->format('Y'),
                );
                $weather = $weatherList->getByTime($offsetTime);
                if ($weather->getCloud()->all < 20) {
                    $this->items[] = new EventSession(
                        (new DateTime('now'))->setTimestamp($offsetTime)
                    );
                }
            }
        }

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
