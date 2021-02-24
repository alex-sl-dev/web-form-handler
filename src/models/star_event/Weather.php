<?php


namespace app\models\star_event;


use stdClass;

/**
 * Class Weather
 * @package app\model
 */
class Weather
{
    /** @var int */
    protected int $dt;

    /** @var stdClass */
    protected stdClass $cloud;

    /**
     * Weather constructor.
     * @param int $dt
     * @param stdClass $cloud
     */
    public function __construct(int $dt, stdClass $cloud)
    {
        $this->dt = $dt;
        $this->cloud = $cloud;
    }

    /**
     * @return int
     */
    public function getDt(): int
    {
        return $this->dt;
    }

    /**
     * @return stdClass
     */
    public function getCloud(): stdClass
    {
        return $this->cloud;
    }
}
