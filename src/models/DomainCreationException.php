<?php


namespace app\models;


use DomainException;



class DomainCreationException extends DomainException
{

    public function __construct($message, $code = 501)
    {
        if (!strlen($message)) {
            $message = "Can't validate initial data for class creation";
        }

        parent::__construct($message, $code );
    }

}
