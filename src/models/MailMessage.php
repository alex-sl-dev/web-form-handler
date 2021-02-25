<?php


namespace app\models;



use app\models\town\Town;
use DateTime;
use Swift_Message;


/**
 * Class Mail
 * @package app\models
 */
class MailMessage extends Swift_Message
{
    protected string $name;
    protected string $email;
    protected Town $town;
    protected DateTime $eventSession;

    public function __construct(
        string $name,
        string $email,
        Town $town,
        DateTime $eventSession
    )
    {
        $this->eventSession = $eventSession;

        parent::__construct('Registration For The Star StarEvent');

        $body = "Hey {$name}, you’ve been registered to the star observers event in {$town->getTown()} ";
        $body .= "on {$this->eventSession->format('l jS \of F')} at {$this->eventSession->format('h')}!";

        $this->setBody($body);
        $this->setFrom('sendmail@local.host', "The Star StarEvent");
        $this->addTo($email, $name);
    }
}
