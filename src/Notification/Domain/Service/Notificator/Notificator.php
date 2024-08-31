<?php

namespace App\Notification\Domain\Service\Notificator;

use App\Notification\Domain\Notification;

interface Notificator
{
    public function send(Notification $notification) : void;
}
