<?php

namespace App\Notificator\Domain;

use App\Notification\Domain\Notification;

interface Notificator
{
    public function send(Notification $notification) : void;
}
