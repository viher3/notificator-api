<?php

namespace App\Notificator\Domain;

use App\Notification\Domain\NotificationCollection;

interface BatchNotificator
{
    public function send(
        NotificationCollection $notifications,
        int $millisecondsDelayBetweenNotifications = 0
    ) : void;
}
