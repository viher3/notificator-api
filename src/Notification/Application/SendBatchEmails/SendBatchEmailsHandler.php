<?php

namespace App\Notification\Application\SendBatchEmails;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Bus\Event\EventBus;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\EmailNotification;
use App\Notification\Domain\NotificationCollection;
use App\Notification\Domain\Service\Email\SendBatchEmailNotificator;

final class SendBatchEmailsHandler implements CommandHandler
{
    public function __construct(
        private SendBatchEmailNotificator $sendBatchEmailNotificator,
        private EventBus $eventBus
    )
    {
    }

    public function execute(SendBatchEmailsCommand $sendBatchEmailsCommand) : void
    {
        $domainEvents = [];
        $notifications = new NotificationCollection();

        foreach($sendBatchEmailsCommand->notifications as $notification){
            $emailNotification = new EmailNotification(
                to: $notification['to'] ?? null,
                from: $notification['from'] ?? null,
                message: $notification['message'] ?? null,
                createdAt: DomainClock::fromString($sendBatchEmailsCommand->createdAt),
                subject: $notification['subject'] ?? ''
            );
            $notifications->add($emailNotification);
            $domainEvents[] = $emailNotification->pullDomainEvents();
        }

        $this->sendBatchEmailNotificator->send($notifications);

        $this->eventBus->publish(...$domainEvents);
    }
}
