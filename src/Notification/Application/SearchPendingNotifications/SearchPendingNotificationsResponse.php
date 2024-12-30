<?php

namespace App\Notification\Application\SearchPendingNotifications;

use App\Core\Application\Query\SearchResponse;
use App\Notification\Domain\Entity\PendingNotificationCollection;

class SearchPendingNotificationsResponse implements SearchResponse
{
    public function __construct(
        private PendingNotificationCollection $pendingNotifications,
        private int $totalPendingNotifications
    )
    {
    }

    public function getResult(): array
    {
        return [
            'pendingNotifications' => $this->pendingNotifications->serialize(),
            'total' => $this->totalPendingNotifications
        ];
    }

    public function getPendingNotifications(): PendingNotificationCollection
    {
        return $this->pendingNotifications;
    }

    public function getTotal(): int
    {
        return $this->totalPendingNotifications;
    }
}