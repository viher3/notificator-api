<?php

namespace App\Notification\Application\SendBatchNotifications;

use App\Core\Domain\Bus\Command\CommandResponse;
use App\Notification\Domain\Entity\NotificationCollection;

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
