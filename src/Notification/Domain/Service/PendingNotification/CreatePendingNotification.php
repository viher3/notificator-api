<?php

namespace App\Notification\Domain\Service\PendingNotification;

use App\Notification\Domain\Notification;
use App\Notification\Domain\PendingNotification;
use App\Notification\Domain\Repository\PendingNotificationRepository;

class CreatePendingNotification
{
    public function __construct(
        private PendingNotificationRepository $notificationPendingRepository
    )
    {
    }

    public function execute(Notification $notification) : void
    {
        $pendingNotification = PendingNotification::fromNotification($notification);
        $this->notificationPendingRepository->save($pendingNotification);
    }
}