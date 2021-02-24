<?php


namespace app\models\star_event;


trait CountableIteratorItemsTrait
{
    /** @var array[] */
    private array $items;

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
