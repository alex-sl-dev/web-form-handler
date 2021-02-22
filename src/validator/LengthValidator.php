<?php


namespace app\validator;

/**
 * Class LengthValidator
 * @package app\validator
 */
class LengthValidator implements ValidatorInterface
{
    /** @var int */
    protected int $rangeFrom;
    /** @var int  */
    protected int $rangeTo;

    /**
     * @param int $from
     * @param int $to
     * @return LengthValidator
     */
    public static function range(int $from, int $to): LengthValidator
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
