<?php

namespace App\Notification\Domain\Service\Notificator;

use App\Notification\Domain\Notification;
use App\Notification\Domain\Enum\NotificationType;
use App\Notification\Domain\PendingNotification;
use App\Notification\Domain\Service\Notificator\Email\SendEmailNotificator;

class NotificatorProviderFactory
{
    public function __construct(
        private SendEmailNotificator $emailNotificator,
    )
    {
    }

    /**
     * @param Notification $notification
     * @return Notificator
     * @throws \Exception
     */
    public function createForNotification(Notification $notification) : Notificator
    {
        return $this->getByType($notification->getType());
    }

    /**
     * @param PendingNotification $pendingNotification
     * @return Notificator
     * @throws \Exception
     */
    public function createForPendingNotification(PendingNotification $pendingNotification) : Notificator
    {
        return $this->getByType($pendingNotification->getType());
    }

    /**
     * @param string $type
     * @return Notificator
     * @throws \Exception
     */
    private function getByType(string $type) : Notificator
    {
        return match ($type){
            NotificationType::EMAIL->value => $this->emailNotificator,
            default => throw new \Exception('Unexpected Notification type.')
        };
    }
}