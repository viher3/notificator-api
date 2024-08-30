<?php

namespace App\Notification\Application\SendSingleEmail;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Bus\Event\EventBus;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\EmailNotification;
use App\Notification\Domain\Service\Email\SendSingleEmailNotificator;

final class SendSingleEmailHandler implements CommandHandler
{
    public function __construct(
        private SendSingleEmailNotificator $sendSingleEmailNotificator,
        private EventBus $eventBus
    )
    {
    }

    public function execute(SendSingleEmailCommand $command) : void
    {
        $notification = new EmailNotification(
            to: $command->recipients,
            from: $command->from,
            message: $command->message,
            createdAt: DomainClock::fromString($command->createdAt),
            subject: $command->subject
        );

        $this->sendSingleEmailNotificator->send($notification);

        $this->eventBus->publish(...$notification->pullDomainEvents());
    }
}
