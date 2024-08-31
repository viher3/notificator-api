<?php

namespace App\Notification\Application\SendBatchEmails;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Bus\Event\EventBus;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\EmailNotification;
use App\Notification\Domain\NotificationCollection;
use App\Notification\Domain\Service\Email\SendSingleEmailNotificator;

final class SendBatchEmailsHandler implements CommandHandler
{
    public function __construct(
        private SendSingleEmailNotificator $sendSingleEmailNotificator,
        private EventBus $eventBus
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function execute(SendBatchEmailsCommand $sendBatchEmailsCommand) : void
    {
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
        }

        $notifications->send($this->sendSingleEmailNotificator);
        $this->eventBus->publish(...$notifications->getDomainEvents());
    }
}
