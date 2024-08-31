<?php

namespace App\Notification\Application\SendPendingNotification;

use App\Core\Domain\Bus\Command\Command;

class SendPendingNotificationCommand implements Command
{
    public function __construct(
        public string $pendingNotificationId,
        public string $currentTime
    )
    {
    }
}