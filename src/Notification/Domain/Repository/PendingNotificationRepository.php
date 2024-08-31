<?php

namespace App\Notification\Domain\Repository;

use App\Core\Domain\Filter\FilterCollection;
use App\Notification\Domain\PendingNotification;

interface PendingNotificationRepository
{
    public function search(
        FilterCollection $filters,
        int $page,
        int $perPage,
        ?string $orderBy = null,
        ?string $orderDirection = null
    ): array;

    public function searchCount(FilterCollection $filters) : int;

    public function save(PendingNotification $pendingNotification) : void;
}