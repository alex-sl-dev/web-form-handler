<?php


namespace app\models\star_event;


use app\validator\Chain;
use app\validator\Email;
use app\validator\Length;
use app\validator\Required;
use app\validator\String;

/**
 * Class StarEvent
 * @package app\models\star_event
 */
class StarEvent
{
    protected string $name;

    protected string $email;

    protected string $town;

    protected string $eventSession;

    protected string $comment;

    public static string $NAME = 'name';
    public static string $EMAIL = 'email';
    public static string $TOWN = 'town';
    public static string $EVENT_SESSION = 'event-session';
    public static string $COMMENT = 'comment';

    /**
     * @var Chain
     */
    protected Chain $formValidator;

    /**
     * Form constructor.
     */
    public function __construct()
    {
        $this->formValidator = new Chain($this->validationRules());
    }

    /**
     * @return array
     */
    private function validationRules(): array
    {
        return [
            // carefully of order
            self::$NAME => [
                Required::class,
                Length::range(0, 50),
                String::class
            ],
            self::$EMAIL => [
                Required::class,
                Length::range(0, 50),
                Email::class
            ],
            self::$TOWN => [
                Required::class
            ],
            self::$EVENT_SESSION => [
                Required::class
            ],
            self::$COMMENT => [
                Length::range(0, 200),
                String::class
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
