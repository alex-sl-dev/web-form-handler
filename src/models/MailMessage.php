<?php


namespace app\models;


use DateTime;
use Swift_Message;


/**
 * Class Mail
 * @package app\models
 */
class MailMessage extends Swift_Message
{
    /** @var string */
    protected string $name;

    /** @var string */
    protected string $email;

    /** @var Town */
    protected Town $town;

    /** @var DateTime */
    protected DateTime $eventSession;

    /**
     * MailMessage constructor.
     * @param string $name
     * @param string $email
     * @param Town $town
     * @param DateTime $eventSession
     */
    public function __construct(
        string $name,
        string $email,
        Town $town,
        DateTime $eventSession
    )
    {
        $this->eventSession = $eventSession;

        parent::__construct('Registration For The Star Event');

        $body = "Hey {$name}, you’ve been registered to the star observers event in {$town->getTown()} ";
        $body .= "on {$this->eventSession->format('l jS \of F')} at {$this->eventSession->format('h')}!";

        $this->setBody($body);
        $this->setFrom('sendmail@local.host', "The Star Event");
        $this->addTo($email, $name);
    }
}
