<?php


namespace app\validator;

/**
 * Class Length
 * @package app\validator
 */
class Length implements Validator
{
    protected int $rangeFrom;
    protected int $rangeTo;

    public static function range(int $from, int $to): Length
    {
        $instance = new self();
        $instance->rangeFrom = $from;
        $instance->rangeTo = $to;

        return $instance;
    }

    public function valid(string $value): bool
    {
        if (!strlen($value)) return true;

        if (strlen($value) < $this->rangeFrom) return false;

        if (strlen($value) > $this->rangeTo) return false;

        return true;
    }

    public function getErrorMessage(): string
    {
        return "Field should be in range, from: {$this->rangeFrom}, to: {$this->rangeTo}";
    }
}
