<?php

namespace App\Notification\Domain\Service;

use App\Notification\Domain\Notification;

interface Notificator
{
    public function send(Notification $notification) : void;
}
