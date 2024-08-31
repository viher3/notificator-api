<?php

namespace App\Notification\Domain\Service\Notificator;

use App\Notification\Domain\Notification;
use App\Notification\Domain\Service\PendingNotification\CreatePendingNotification;

class SendNotificationStrategy
{
    public function __construct(
        private NotificatorProviderFactory $notificatorProviderFactory,
        private CreatePendingNotification $createPendingNotification
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function execute(Notification $notification) : Notification
    {
        $sendService = $this->notificatorProviderFactory->createForNotification($notification);

        if (!$notification->isSendConfirmationRequired()) {
            // Send notification
            $notification->send($sendService);
        } else {
            // Save notification as pending status
            $this->createPendingNotification->execute($notification);
        }

        return $notification;
    }
}