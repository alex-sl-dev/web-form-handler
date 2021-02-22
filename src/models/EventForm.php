<?php


namespace app\models;


use app\validator\EmailValidator;
use app\validator\LengthValidator;
use app\validator\RequiredValidator;
use app\validator\StringValidator;
use app\validator\ValidatorChain;


/**
 * Class EventForm
 * @package app\model
 */
class EventForm
{
    public static string $NAME = 'name';
    public static string $EMAIL = 'email';
    public static string $TOWN = 'town';
    public static string $EVENT_SESSION = 'event-session';
    public static string $COMMENT = 'comment';

    /**
     * @var ValidatorChain
     */
    protected ValidatorChain $formValidator;

    /**
     * EventForm constructor.
     */
    public function __construct()
    {
        $this->formValidator = new ValidatorChain($this->validationRules());
    }

    /**
     * @return array
     */
    private function validationRules(): array
    {
        return [
            // carefully of order
            self::$NAME => [
                RequiredValidator::class,
                LengthValidator::range(0, 50),
                StringValidator::class
            ],
            self::$EMAIL => [
                RequiredValidator::class,
                LengthValidator::range(0, 50),
                EmailValidator::class
            ],
            self::$TOWN => [
                RequiredValidator::class
            ],
            self::$EVENT_SESSION => [
                RequiredValidator::class
            ],
            self::$COMMENT => [
                LengthValidator::range(0, 200),
                StringValidator::class
            ]
        ];

    }

    /**
     * @param array $post
     */
    public function setFormData(array $post)
    {

    }

    /**
     * @param array $post
     */
    public function handleRequest(array $post)
    {
        $this->formValidator->invoke($post);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->formValidator->getErrors();
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return boolval(count($this->formValidator->getErrors()));
    }
}
