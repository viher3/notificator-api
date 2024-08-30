<?php

namespace App\Notification\Domain\Repository;

use App\Notification\Domain\NotificationLog;

interface NotificationLogRepository
{
    public function save(NotificationLog $notificationLog) : void;
}