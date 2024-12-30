<?php

namespace App\Notification\Domain\Service\PendingNotification;

use App\Core\Domain\Time\Clock;
use App\Notification\Domain\Entity\PendingNotification;
use App\Notification\Domain\Factory\NotificationFactory;
use App\Notification\Domain\Service\Notificator\NotificatorProviderFactory;

class SendPendingNotification
{
    public function __construct(
        private NotificatorProviderFactory $notificatorProviderFactory,
        private NotificationFactory $notificationFactory
    )
    {
    }

    /**
     * @param PendingNotification $pendingNotification
     * @param Clock $currentTime
     * @throws \Exception
     */
    public function execute(
        PendingNotification $pendingNotification,
        Clock $currentTime
    ) : void
    {
        $sendService = $this->notificatorProviderFactory->createForPendingNotification($pendingNotification);

        $pendingNotification->send(
            notificator: $sendService,
            notificationFactory: $this->notificationFactory,
            currentTime: $currentTime
        );
    }
}