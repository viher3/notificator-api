<?php

namespace App\NotificationChannel\Domain\Service\Email;

use App\Notification\Domain\Entity\EmailNotification;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;

class NotificationChannelMailerAdapter
{
    public function adapt(EmailNotification $notification) : MailerInterface
    {
        // Create the transport string dynamically
        $dsn = sprintf(
            '%s://%s:%s@%s:%s',
            'smtp',
            $notification->getOptions()['user'],
            $notification->getOptions()['password'],
            $notification->getOptions()['host'],
            $notification->getOptions()['port']
        );

        // Create a new transport
        $transport = Transport::fromDsn($dsn);

        // Return the dynamically created mailer
        return new Mailer($transport);
    }
}