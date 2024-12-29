<?php

namespace App\Notification\Domain;

use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\Enum\NotificationType;
use App\Notification\Domain\Factory\NotificationDto;

class TelegramNotification extends Notification
{
    /**
     * @param NotificationDto $dto
     * @return self
     * @throws \Exception
     */
    public static function fromNotificationDto(NotificationDto $dto) : self
    {
        return new self(
            type: NotificationType::TELEGRAM->value,
            to: $dto->to,
            from: $dto->from,
            message: $dto->message,
            createdAt: DomainClock::fromString($dto->createdAt),
            subject: '',
            options: $dto->options,
            isSendConfirmationRequired: $dto->isSendConfirmationRequired
        );
    }
}
