<?php


namespace app\validator;

/**
 * Class Length
 * @package app\validator
 */
class Length implements Validator
{
    /** @var int */
    protected int $rangeFrom;
    /** @var int  */
    protected int $rangeTo;

    /**
     * @param int $from
     * @param int $to
     * @return Length
     */
    public static function range(int $from, int $to): Length
    {
        $instance = new self();
        $instance->rangeFrom = $from;
        $instance->rangeTo = $to;

        return $instance;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function valid(string $value): bool
    {
        if (!strlen($value)) return true;

        if (strlen($value) < $this->rangeFrom) return false;

        if (strlen($value) > $this->rangeTo) return false;

        return true;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return "Field should be in range, from: {$this->rangeFrom}, to: {$this->rangeTo}";
    }
}
