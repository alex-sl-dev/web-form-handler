<?php


namespace app\models\star_event;


use app\models\town\Town;
use app\validator\Chain;
use app\validator\Email;
use app\validator\Length;
use app\validator\Required;
use app\validator\StringClass;
use DomainException;

/**
 * Class StarEvent
 * @package app\models\star_event
 */
class StarEvent
{
    public static string $NAME = 'name';
    public static string $EMAIL = 'email';
    public static string $TOWN = 'town';
    public static string $EVENT = 'event-session';
    public static string $COMMENT = 'comment';

    /** @var string */
    protected string $name;
    /** @var string */
    protected string $email;
    /** @var Town */
    protected Town $town;
    /** @var EventSession */
    protected EventSession $eventSession;
    /** @var string */
    protected string $comment;
    /** @var Chain */
    protected Chain $validator;

    /**
     * Form constructor.
     * @param string $name
     * @param string $email
     * @param Town $town
     * @param EventSession $eventSession
     * @param string $comment
     */
    public function __construct(
        string $name,
        string $email,
        Town $town,
        EventSession $eventSession,
        string $comment
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->town = $town;
        $this->eventSession = $eventSession;
        $this->comment = $comment;

        $this->validator = new Chain($this->validationRules(), $this->toArray(true));

        $this->hasErrors();
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
                StringClass::class
            ],
            self::$EMAIL => [
                Required::class,
                Length::range(0, 50),
                Email::class
            ],
            self::$TOWN => [
                Required::class
            ],
            self::$EVENT => [
                Required::class
            ],
            self::$COMMENT => [
                Length::range(0, 200),
                StringClass::class
            ]
        ];
    }

    /**
     * @param bool $force
     * @return string[]
     */
    public function toArray($force = false): array
    {
        if ($force || empty($this->hasErrors())) {

            return [
                self::$NAME => $this->name,
                self::$EMAIL => $this->email,
                self::$TOWN => $this->town->getTown(),
                self::$EVENT => $this->eventSession->getDateTime()->getTimestamp(),
                self::$COMMENT => $this->comment
            ];
        }

        throw new DomainCreationException("Can't serialise:" . __CLASS__);
    }

    /**
     * @return bool
     */
    private function hasErrors(): bool
    {
        return $this->validator->hasErrors();
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->validator->getErrors();
    }
}
