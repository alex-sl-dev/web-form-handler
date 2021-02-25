<?php


namespace app\models\town;


use app\models\CountableIteratorTrait;
use Countable;
use Iterator;


/**
 * Class TownsList
 * @package app\model
 */
class TownsList implements Iterator, Countable
{

    use CountableIteratorTrait;

    public function __construct(array $items)
    {
        $this->items = [];
        foreach ($items as $record) {
            array_push($this->items, new Town($record->id, $record->town));
        }
    }
}
