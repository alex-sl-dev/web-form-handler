<?php


namespace app\validator;

/**
 * Class Email
 * @package app\validator
 */
class Email implements Validator
{

    public function valid(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function getErrorMessage(): string
    {
        return 'Value should be a valid email address, like: <em>John.Doe@domain.com</em>';
    }
}
