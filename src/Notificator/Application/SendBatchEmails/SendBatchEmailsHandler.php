<?php

namespace App\Notificator\Application\SendBatchEmails;

use App\Core\Application\Command\CommandHandler;
use App\Notification\Domain\EmailNotification;
use App\Notification\Domain\NotificationCollection;
use App\Notificator\Domain\Service\SendBatchEmailNotificator;

final class SendBatchEmailsHandler implements CommandHandler
{
    public function __construct(
        private SendBatchEmailNotificator $sendBatchEmailNotificator
    )
    {
    }

    public function execute(SendBatchEmailsCommand $sendBatchEmailsCommand) : void
    {
        $notifications = new NotificationCollection();

        foreach($sendBatchEmailsCommand->notifications as $notification){
            $notifications->add(
                new EmailNotification(
                    to: $notification['to'] ?? null,
                    from: $notification['from'] ?? null,
                    message: $notification['message'] ?? null,
                    subject: $notification['subject'] ?? ''
                )
            );
        }

        $this->sendBatchEmailNotificator->send($notifications);
    }
}
