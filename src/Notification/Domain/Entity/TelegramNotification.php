<?php

namespace App\Notification\Domain\Entity;

use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\Enum\NotificationType;
use App\Notification\Domain\Factory\NotificationDto;
use App\NotificationChannel\Domain\Entity\NotificationChannel;

class TelegramNotification extends Notification
{
    /**
     * @param NotificationDto $dto
     * @return self
     * @throws \Exception
     */
    public static function fromNotificationDto(
        NotificationDto $dto,
        NotificationChannel $notificationChannel
    ) : self
    {
        return new self(
            type: NotificationType::TELEGRAM->value,
            to: $notificationChannel->getConfig('chatId'),
            from: $notificationChannel->getConfig('botToken'),
            message: $dto->message,
            createdAt: DomainClock::fromString($dto->createdAt),
            subject: '',
            options: $dto->options,
            isSendConfirmationRequired: $dto->isSendConfirmationRequired
        );
    }
}
