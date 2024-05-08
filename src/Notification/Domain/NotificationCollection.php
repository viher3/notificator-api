<?php

namespace App\Notification\Domain;

use Ramsey\Collection\AbstractCollection;

class NotificationCollection extends AbstractCollection
{
    public function getType(): string
    {
        return Notification::class;
    }
}