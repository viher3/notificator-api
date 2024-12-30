<?php

namespace App\Notification\Domain\Entity;

use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\Enum\NotificationType;
use App\Notification\Domain\Factory\NotificationDto;
use App\NotificationChannel\Domain\Entity\NotificationChannel;

class EmailNotification extends Notification
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
        $options = [
            'host' => $notificationChannel->getConfig('host'),
            'port' => $notificationChannel->getConfig('port'),
            'user' => $notificationChannel->getConfig('user'),
            'password' => $notificationChannel->getConfig('password'),
        ];

        return new self(
            type: NotificationType::EMAIL->value,
            to: $dto->to,
            from: $notificationChannel->getConfig('user'),
            message: $dto->message,
            createdAt: DomainClock::fromString($dto->createdAt),
            subject: $dto->subject,
            options: $options,
            isSendConfirmationRequired: $dto->isSendConfirmationRequired
        );
    }
}
