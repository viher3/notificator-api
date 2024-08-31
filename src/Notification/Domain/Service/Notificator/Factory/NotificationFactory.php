<?php

namespace App\Notification\Domain\Service\Notificator\Factory;

use App\Notification\Domain\EmailNotification;
use App\Notification\Domain\Enum\NotificationType;
use App\Notification\Domain\Notification;

class NotificationFactory
{
    /**
     * @throws \Exception
     */
    public function create(NotificationDto $notificationDto) : Notification
    {
        return match ($notificationDto->type){
            NotificationType::EMAIL->value => EmailNotification::fromNotificationDto($notificationDto),
            default => throw new \Exception('Unexpected Notification type.')
        };
    }
}