<?php

namespace App\Notification\Application\SendBatchNotifications;

use App\Core\Application\Command\CommandResponse;
use App\Notification\Domain\NotificationCollection;

readonly class SendBatchNotificationsResponse implements CommandResponse
{
    public function __construct(
        public NotificationCollection $notifications,
    )
    {
    }

    public function getResult(): array
    {
        return [
            'totalSubmitted' => $this->notifications->getTotalSubmittedSuccessfully(),
            'totalErrors' => count($this->notifications->getErrors()),
            'errors' => $this->notifications->getErrors()
        ];
    }
}
