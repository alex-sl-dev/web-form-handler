<?php


namespace app\validator;


class RequiredValidator implements ValidatorInterface
{

    public function valid(string $value): bool
    {
        if ($value == '0') { // dirty hack for select tag
            return false;
        }

        return (strlen($value)) ? true : false;
    }

    public function getErrorMessage(): string
    {
        return "Field are required";
    }
}
