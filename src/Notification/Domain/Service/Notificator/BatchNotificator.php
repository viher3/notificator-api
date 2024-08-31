<?php

namespace App\Notification\Domain\Service\Notificator;

use App\Notification\Domain\NotificationCollection;

interface BatchNotificator
{
    public function send(
        NotificationCollection $notifications,
        int $millisecondsDelayBetweenNotifications = 0
    ) : void;
}
