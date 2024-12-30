<?php

namespace App\NotificationChannel\Domain\ValueObject;

use App\Core\Domain\ValueObject\StringValueObject;
use App\Notification\Domain\Enum\NotificationType;
use App\NotificationChannel\Domain\Exception\InvalidProvider;

class Provider extends StringValueObject
{
    public function __construct(string $value)
    {
        $notificationTypes = array_map(fn(NotificationType $type) => $type->value, NotificationType::cases());

        if(!in_array($value, $notificationTypes)){
            throw new InvalidProvider($value);
        }

        parent::__construct($value);
    }
}