<?php

namespace App\Notification\Domain\Factory;

use App\Notification\Domain\Entity\EmailNotification;
use App\Notification\Domain\Entity\Notification;
use App\Notification\Domain\Entity\TelegramNotification;
use App\Notification\Domain\Enum\NotificationType;

class NotificationFactory
{
    /**
     * @throws \Exception
     */
    public function create(NotificationDto $notificationDto) : Notification
    {
        return match ($notificationDto->type){
            NotificationType::EMAIL->value => EmailNotification::fromNotificationDto($notificationDto),
            NotificationType::TELEGRAM->value => TelegramNotification::fromNotificationDto($notificationDto),
            default => throw new \Exception('Unexpected Notification type.')
        };
    }
}