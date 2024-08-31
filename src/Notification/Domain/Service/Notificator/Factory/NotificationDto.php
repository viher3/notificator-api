<?php

namespace App\Notification\Domain\Service\Notificator\Factory;

final class NotificationDto
{
    public function __construct(
        public string $type,
        public array $to,
        public string $from,
        public string $message,
        public string $createdAt,
        public ?string $subject = null,
        public array $options = [],
        public bool $isSendConfirmationRequired = false
    )
    {
    }
}