<?php


namespace app\models\star_event;


use stdClass;

/**
 * Class Weather
 * @package app\model
 */
class Weather
{
    protected int $dt;
    protected stdClass $cloud;

    public function __construct(int $dt, stdClass $cloud)
    {
        $this->dt = $dt;
        $this->cloud = $cloud;
    }

    public function getDt(): int
    {
        return $this->dt;
    }

    public function getCloud(): stdClass
    {
        return $this->cloud;
    }
}
