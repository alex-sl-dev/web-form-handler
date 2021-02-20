<?php


namespace app\validator;


class StringValidator implements ValidatorInterface
{

    public function valid(string $value): bool
    {
        if (!strlen($value)) return true;

        $regexp = "/[a-zA-Z\s]*/";

        // want work correctly $a = filter_var($value, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $regexp]]);

        preg_match($regexp, $value, $matches, PREG_OFFSET_CAPTURE);

        if (strlen($matches[0][0]) !== strlen($value)) {
            return  false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return "Allowed just alphabet chars";
    }
}
