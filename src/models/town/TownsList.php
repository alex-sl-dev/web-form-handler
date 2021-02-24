<?php


namespace app\models\town;


use app\models\star_event\CountableIteratorItemsTrait;
use Countable;
use Iterator;


/**
 * Class TownsList
 * @package app\model
 */
class TownsList implements Iterator, Countable
{

    use CountableIteratorItemsTrait;

    public function __construct($array)
    {
        if (is_array($array)) {
            $this->items = $array;
        }
    }

    public static function create(array $fetched): self
    {
        $records = [];

        foreach ($fetched as $record) {
            array_push($records, new Town($record->id, $record->town));
        }

        return new self($records);
    }

}
