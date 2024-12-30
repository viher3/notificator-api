<?php

namespace App\NotificationChannel\Domain\Exception;

use App\Core\Domain\DomainError;

final class NotificationChannelNotFound extends DomainError
{
    public function errorCode(): string
    {
        return 404;
    }

    public function errorMessage(): string
    {
        return 'Notification channel not found';
    }

    public function errorTranslationKey(): string
    {
        return 'notification_channel.not_found';
    }
}