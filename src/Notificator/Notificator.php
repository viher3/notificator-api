<?php

namespace App\Notificator;

use App\Notification\Domain\Notification;

interface Notificator
{
    public function send(Notification $notification) : void;
}
