<?php

namespace App\Notification\Domain\Exception;

use App\Core\Domain\DomainError;

class NotFoundPendingNotification extends DomainError
{
    public function errorCode(): string
    {
        return 404;
    }

    public function errorMessage(): string
    {
        return 'Pending notification not found';
    }

    public function errorTranslationKey(): string
    {
        return 'pendingNotification.not_found';
    }
}