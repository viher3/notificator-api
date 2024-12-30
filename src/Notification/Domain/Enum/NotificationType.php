<?php

namespace App\Notification\Domain\Enum;

enum NotificationType : string
{
    case EMAIL = 'email';
    case TELEGRAM = 'telegram';
}