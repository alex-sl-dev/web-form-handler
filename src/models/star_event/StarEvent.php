<?php


namespace app\models\star_event;


use app\models\town\Town;
use app\validator\ValidatorChain;
use app\validator\Email;
use app\validator\Length;
use app\validator\Required;
use app\validator\StringClass;
use DomainException;

class StarEvent
{
    public static string $NAME = 'name';
    public static string $EMAIL = 'email';
    public static string $TOWN = 'town';
    public static string $EVENT = 'event-session';
    public static string $COMMENT = 'comment';

    protected string $name;
    protected string $email;
    protected Town $town;
    protected EventSession $eventSession;
    protected string $comment;
    protected ValidatorChain $validator;

    public function __construct(
        string $name,
        string $email,
        Town $town,
        string $comment
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->town = $town;
        $this->eventSession = new EventSession();
        $this->comment = $comment;

        $this->validator = new ValidatorChain($this->validationRules(), $this->toArray());

        $this->hasErrors();
    }

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

    public function toArray(): array
    {
        $eventTimestamp = 0;

        if ($this->eventSession) {
            $eventTimestamp = $this->eventSession->getDateTime()->getTimestamp();
        }

        // throw new DomainCreationException("Can't serialise:" . __CLASS__);

        return [
            self::$NAME => $this->name,
            self::$EMAIL => $this->email,
            self::$TOWN => $this->town->getTown(),
            self::$EVENT => $eventTimestamp,
            self::$COMMENT => $this->comment
        ];
    }

    private function hasErrors(): bool
    {
        return $this->validator->hasErrors();
    }

    public function getErrors(): array
    {
        return $this->validator->getErrors();
    }

    public function setEventSession(EventSession $eventSession): self
    {
        $this->eventSession = $eventSession;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Town
     */
    public function getTown(): Town
    {
        return $this->town;
    }

    /**
     * @return EventSession
     */
    public function getEventSession(): EventSession
    {
        return $this->eventSession;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

}
