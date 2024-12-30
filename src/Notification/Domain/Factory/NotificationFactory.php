<?php

namespace App\Notification\Domain\Factory;

use App\Notification\Domain\Entity\EmailNotification;
use App\Notification\Domain\Entity\Notification;
use App\Notification\Domain\Entity\TelegramNotification;
use App\Notification\Domain\Enum\NotificationType;
use App\NotificationChannel\Domain\Repository\NotificationChannelRepository;

class NotificationFactory
{
    public function __construct(
        private NotificationChannelRepository $notificationChannelRepository
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function create(NotificationDto $notificationDto) : Notification
    {
        $notificationChannel = $this->notificationChannelRepository->findOrFail($notificationDto->notificationChannelId);

        return match ($notificationChannel->getProvider()){
            NotificationType::EMAIL->value => EmailNotification::fromNotificationDto($notificationDto, $notificationChannel),
            NotificationType::TELEGRAM->value => TelegramNotification::fromNotificationDto($notificationDto, $notificationChannel),
            default => throw new \Exception('Unexpected Notification type.')
        };
    }
}