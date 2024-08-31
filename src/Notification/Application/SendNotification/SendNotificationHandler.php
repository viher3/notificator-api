<?php

namespace App\Notification\Application\SendNotification;

use App\Core\Domain\Time\DomainClock;
use App\Core\Domain\Bus\Event\EventBus;
use App\Core\Application\Command\CommandHandler;
use App\Notification\Domain\Service\Notificator\Factory\NotificationDto;
use App\Notification\Domain\Service\Notificator\Factory\NotificationFactory;
use App\Notification\Domain\Service\Notificator\SendNotificationStrategy;

final class SendNotificationHandler implements CommandHandler
{
    public function __construct(
        private SendNotificationStrategy $sendNotificationStrategy,
        private EventBus                 $eventBus,
        private NotificationFactory      $notificationFactory
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function execute(SendNotificationCommand $command): void
    {
        $notification = $this->notificationFactory->create(
            new NotificationDto(
                type: $command->type,
                to: $command->recipients,
                from: $command->from,
                message: $command->message,
                recipients: $command->recipients,
                createdAt: DomainClock::fromString($command->createdAt),
                subject: $command->subject,
                isSendConfirmationRequired: $command->isSendConfirmationRequired
            )
        );

        $notification = $this->sendNotificationStrategy->execute($notification);
        $this->eventBus->publish(...$notification->pullDomainEvents());
    }
}
