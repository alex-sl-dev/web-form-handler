<?php


namespace app\validator;


interface Validator
{
    public function valid(string $value) : bool;
    public function getErrorMessage() : string;
}
