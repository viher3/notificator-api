<?php

namespace App\Notification\Application\SendBatchEmails;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\EmailNotification;
use App\Notification\Domain\NotificationCollection;
use App\Notification\Domain\Service\Email\SendBatchEmailNotificator;

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
                    createdAt: DomainClock::fromString($sendBatchEmailsCommand->createdAt),
                    subject: $notification['subject'] ?? ''
                )
            );
        }

        $this->sendBatchEmailNotificator->send($notifications);
    }
}
