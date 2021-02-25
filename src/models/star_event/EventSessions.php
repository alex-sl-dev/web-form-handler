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
     */
    public function __construct()
    {
        for ($day = 0; $day < 5; $day++) {
            foreach (EventSessions::$EVENT_HOURS as $hour) {
                $offsetTime = mktime($hour, null, null,
                    (new DateTime())->format('n'),
                    (new DateTime())->add(new DateInterval("P{$day}D"))->format('j'),
                    (new DateTime())->format('Y'),
                );
                $this->items[] = new EventSession(
                    (new DateTime('now'))->setTimestamp($offsetTime)
                );
            }
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [];

        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                /** @var EventSession $item */
                $json[] = [
                    'dt' => $item->getDateTime()->getTimestamp(),
                    'label' => $item->getDateTime()->format(EventSession::$DEFAULT_FORMAT_DATETIME),
                ];
            }
        }

        if (empty($json)) {
            // todo cont catch correctly throw new DomainCreationException("Can't serialise: " . __CLASS__);
        }

        return $json;
    }

    public function getSunnySessions(Town $town): EventSessions
    {
        $weatherService = new WeatherProviderService();
        $weatherService->fetch($town->getTown());
        $weathersCollection = $weatherService->getWeatherCollection();

        $filtered = [];

        /** @var EventSession $item */
        foreach ($this->items as $item) {
            // @todo fix by time $weather = $weathersCollection->getByTime($item->getDateTime()->getTimestamp());
            $weather = $weathersCollection->getFirst();

            if ($weather->getCloud()->all < 50) {
                $filtered[] = $item;
            }
        }

        $this->items = $filtered;

        return $this;
    }
}
