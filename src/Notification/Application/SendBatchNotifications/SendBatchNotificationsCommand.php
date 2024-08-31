<?php

namespace App\Notification\Application\SendBatchNotifications;

use App\Core\Application\Command\Command;

readonly class SendBatchNotificationsCommand implements Command
{
    public function __construct(
        public array $notifications,
        public string $createdAt
    )
    {
    }
}
