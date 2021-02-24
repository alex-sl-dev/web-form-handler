<?php


namespace app\models\town;


use Countable;
use Iterator;


/**
 * Class TownsList
 * @package app\model
 */
class TownsList implements Iterator, Countable
{

    /** @var Town[] */
    protected array $items;

    public function __construct($array)
    {
        if (is_array($array)) {
            $this->items = $array;
        }
    }

    public static function fromPDO(array $fetched): self
    {
        $records = [];

        foreach ($fetched as $record) {
            array_push($records, new Town($record->id, $record->town));
        }

        return new self($records);
    }

    public function getItems(): array
    {
        return $this->items;
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
}
