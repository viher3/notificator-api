<?php

namespace App\Notification\Domain\Service\Notificator\Email;

use App\Notification\Domain\Entity\Notification;
use App\Notification\Domain\Exception\SendNotificationException;
use App\Notification\Domain\Service\Notificator\Notificator;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class EmailNotificator implements Notificator
{
    public function __construct(
        private MailerInterface $mailer
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
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

        try{
            $this->mailer->send($email);
        }catch (\Exception $e){
            throw new SendNotificationException(
                'Error sending Email notification: ' . $e->getMessage()
            );
        }
    }
}
