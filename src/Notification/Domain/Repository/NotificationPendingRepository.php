<?php

namespace App\Notification\Domain\Repository;

use App\Notification\Domain\PendingNotification;

interface NotificationPendingRepository
{
    public function save(PendingNotification $pendingNotification) : void;
}