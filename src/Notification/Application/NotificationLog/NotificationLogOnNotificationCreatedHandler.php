<?php

namespace App\Notification\Application\NotificationLog;

use App\Core\Domain\Bus\Event\EventHandler;
use App\Notification\Domain\Event\NotificationCreated;
use App\Notification\Domain\NotificationLog;
use App\Notification\Domain\Repository\NotificationLogRepository;

/**
 * Create a NotificationLog and persist in database when a Notification has been created and sent successfully.
 */
class NotificationLogOnNotificationCreatedHandler implements EventHandler
{
    public function __construct(
        private NotificationLogRepository $notificationLogRepository
    )
    {
    }

    public function __invoke(NotificationCreated $notificationCreated) : void
    {
        $notificationLog = NotificationLog::fromNotification($notificationCreated->getNotification());
        $this->notificationLogRepository->save($notificationLog);
    }
}