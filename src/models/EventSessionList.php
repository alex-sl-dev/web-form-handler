<?php


namespace app\models;


use Countable;
use DateInterval;
use DateTime;
use Iterator;
use JsonSerializable;


/**
 * Class EventSessionList
 * @package app\model
 */
class EventSessionList implements Iterator, Countable, JsonSerializable
{
    /** @var EventSession[] */
    private array $items;

    /** @var array|int[]  */
    private static array $sessionStartHours = [14, 17, 20, 23];

    /**
     * @param WeatherList $weatherList
     * @param bool $ignoreWeather
     * @return EventSessionList
     */
    public static function createFutureSessions(
        WeatherList $weatherList,
        bool $ignoreWeather = false
    ) : EventSessionList{
        $instance = new self();

        for ($day = 0; $day < 5; $day++) {
            foreach (EventSessionList::$sessionStartHours as $hour) {
                $weather = $weatherList->getByTime(mktime(
                    $hour, null, null,
                    (new DateTime())->format('n'),
                    (new DateTime())->add(new DateInterval('P1D'))->format('j'),
                    (new DateTime())->format('Y'),
                ));
                if ($weather->getCloud()->all < 20 || $ignoreWeather) {
                    $instance->items[] = new EventSession($weather, $hour, $day);
                }
            }
        }

        return $instance;
    }

    public function current()// Uncaught TypeError:: Town
    {
        return current($this->items);
    }

    public function next()//Uncaught TypeError: : //Town
    {
        return next($this->items);
    }

    public function key(): int
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        $key = key($this->items);

        return ($key !== NULL && $key !== FALSE);
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $response = [];

        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $response[] = [
                    'dt' => $item->getStartTime()->getTimestamp(),
                    'label' => $item->getStartTime()->format('l jS \of F Y h:i:s A'),
                ];
            }
        }

        return $response;
    }
}
