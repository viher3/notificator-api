<?php

namespace App\Notification\Application\SendBatchNotifications;

use App\Core\Domain\Bus\Command\CommandHandler;
use App\Core\Domain\Bus\Event\EventBus;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\NotificationCollection;
use App\Notification\Domain\Service\Notificator\Factory\NotificationDto;
use App\Notification\Domain\Service\Notificator\Factory\NotificationFactory;
use App\Notification\Domain\Service\Notificator\SendNotificationStrategy;

final class SendBatchNotificationsHandler implements CommandHandler
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
    public function __invoke(SendBatchNotificationsCommand $sendBatchEmailsCommand): SendBatchNotificationsResponse
    {
        $notifications = new NotificationCollection();

        foreach ($sendBatchEmailsCommand->notifications as $notification) {
            $notification = $this->notificationFactory->create(
                new NotificationDto(
                    type: $notification['type'],
                    to: $notification['to'] ?? null,
                    from: $notification['from'] ?? null,
                    message: $notification['message'] ?? null,
                    createdAt: DomainClock::fromString($sendBatchEmailsCommand->createdAt),
                    subject: $notification['subject'] ?? '',
                    isSendConfirmationRequired: $notification['isSendConfirmationRequired'] ?? false
                )
            );

            $notifications->add($notification);
        }

        $notifications->send($this->sendNotificationStrategy);
        $this->eventBus->publish(...$notifications->getDomainEvents());

        return new SendBatchNotificationsResponse($notifications);
    }
}
