<?php

namespace App\Notification\Application\SendNotification;

use App\Core\Domain\Bus\Command\CommandHandler;
use App\Core\Domain\Bus\Command\CommandResponse;
use App\Core\Domain\Bus\Command\EmptyCommandResponse;
use App\Core\Domain\Bus\Event\EventBus;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\Factory\NotificationDto;
use App\Notification\Domain\Factory\NotificationFactory;
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
    public function __invoke(SendNotificationCommand $command): CommandResponse
    {
        $notification = $this->notificationFactory->create(
            new NotificationDto(
                notificationChannelId: $command->notificationChannelId,
                to: $command->recipients,
                message: $command->message,
                createdAt: DomainClock::fromString($command->createdAt),
                subject: $command->subject,
                isSendConfirmationRequired: $command->isSendConfirmationRequired
            )
        );

        $notification = $this->sendNotificationStrategy->execute($notification);
        $this->eventBus->publish(...$notification->pullDomainEvents());

        return new EmptyCommandResponse();
    }
}
