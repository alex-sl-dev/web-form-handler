<?php


namespace app\validator;

/**
 * Class EmailValidator
 * @package app\validator
 */
class EmailValidator implements ValidatorInterface
{

    /**
     * @param string $value
     * @return bool
     */
    public function valid(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return 'Value should be a valid email address, like: <em>John.Doe@domain.com</em>';
    }
}
