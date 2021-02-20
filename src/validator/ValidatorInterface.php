<?php


namespace app\validator;


interface ValidatorInterface
{
    public function valid(string $value) : bool;

    public function getErrorMessage() : string;
}
