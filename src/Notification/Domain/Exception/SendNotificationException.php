<?php

namespace App\Notification\Domain\Exception;

use App\Core\Domain\DomainError;

final class SendNotificationException extends DomainError
{
    public function __construct(
        string $defaultMessage = 'Error sending notification'
    )
    {
        $this->message = $defaultMessage;
    }

    public function errorCode(): string
    {
        return 500;
    }

    public function errorMessage(): string
    {
        return $this->message;
    }

    public function errorTranslationKey(): string
    {
        return 'notification.sent_error';
    }
}