<?php


namespace app\validator;


/**
 * Class Required
 * @package app\validator
 */
class Required implements Validator
{

    /**
     * @param string $value
     * @return bool
     */
    public function valid(string $value): bool
    {
        if ($value == '0') { // dirty hack for select tag
            return false;
        }

        return (strlen($value)) ? true : false;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return "Field are required";
    }
}
