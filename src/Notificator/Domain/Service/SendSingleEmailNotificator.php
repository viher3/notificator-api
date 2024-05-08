<?php

namespace App\Notificator\Domain\Service;

use App\Notification\Domain\Notification;
use App\Notificator\Domain\Notificator;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class SendSingleEmailNotificator implements Notificator
{
    public function __construct(
        private MailerInterface $mailer
    )
    {
    }

    public function send(Notification $notification): void
    {
        $email = new Email();
        $email->from($notification->getFrom());
        $email->html($notification->getMessage());

        if($notification->getSubject()){
            $email->subject($notification->getSubject());
        }

        foreach($notification->getTo() as $to){
            $email->addTo($to);
        }

        $this->mailer->send($email);
    }
}
