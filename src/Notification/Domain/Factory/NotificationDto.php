<?php

namespace App\Notification\Domain\Factory;

final class NotificationDto
{
    public function __construct(
        public string $notificationChannelId,
        public array $to,
        public string $message,
        public string $createdAt,
        public ?string $subject = null,
        public array $options = [],
        public bool $isSendConfirmationRequired = false
    )
    {
    }
}