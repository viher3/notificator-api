<?php

namespace App\Notification\Domain\Service\Email;

use App\Notification\Domain\NotificationCollection;
use App\Notification\Domain\Service\BatchNotificator;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class SendBatchEmailNotificator implements BatchNotificator
{
    public function __construct(
        private MailerInterface $mailer
    )
    {
    }

    public function send(
        NotificationCollection $notifications,
        int $millisecondsDelayBetweenNotifications = 0
    ): void
    {
        foreach($notifications as $notification){
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
            sleep($millisecondsDelayBetweenNotifications);
        }
    }
}
