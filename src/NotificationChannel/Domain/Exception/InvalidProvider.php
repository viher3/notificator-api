<?php

namespace App\NotificationChannel\Domain\Exception;

use App\Core\Domain\DomainError;

class InvalidProvider extends DomainError
{
    public function __construct(
        private readonly string $value
    )
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Invalid notification channel provider: ' . $this->value;
    }

    public function errorTranslationKey(): string
    {
        return 'notification_channel.invalid_provider';
    }
}