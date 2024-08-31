<?php

namespace App\Notification\Domain\Filter\PendingNotification;

use App\Core\Domain\Filter\Filter;

interface SentAtIsNullFilter
{
    public function create() : Filter;
}