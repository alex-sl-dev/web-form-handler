<?php

namespace app\services;

use app\models\MailMessage;
use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_Transport_SmtpAgent;

/**
 * Class SendMailService
 * @package app\services
 */
class MailTransportService
{
    /** @var Swift_Transport_SmtpAgent */
    protected Swift_Transport_SmtpAgent $transport;

    /**
     * MailTransportService constructor.
     */
    public function __construct()
    {
        $iniFile = parse_ini_file(realpath(__DIR__ . "/../../config.ini"), true);
        $smtp = $iniFile['smtp'];

        $this->transport = new Swift_SmtpTransport($smtp['host'], $smtp['host']);
        $this->transport->setUsername($smtp['user']);
        $this->transport->setPassword($smtp['password']);
    }

    /**
     * @param MailMessage $mailMessage
     * @return int
     */
    public function send(MailMessage $mailMessage): int
    {
        $mailer = new Swift_Mailer($this->transport);

        return $mailer->send($mailMessage);
    }
}
