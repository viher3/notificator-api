<?php

namespace App\Notification\Domain\Repository;

use App\Core\Domain\Filter\FilterCollection;
use App\Notification\Domain\PendingNotification;
use App\Notification\Domain\ValueObject\PendingNotificationId;

interface PendingNotificationRepository
{
    /**
     * @param FilterCollection $filters
     * @param int $page
     * @param int $perPage
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @return array
     */
    public function search(
        FilterCollection $filters,
        int $page,
        int $perPage,
        ?string $orderBy = null,
        ?string $orderDirection = null
    ): array;

    /**
     * @param FilterCollection $filters
     * @return int
     */
    public function searchCount(FilterCollection $filters) : int;

    /**
     * @param PendingNotification $pendingNotification
     * @return void
     */
    public function save(PendingNotification $pendingNotification) : void;

    /**
     * @param PendingNotificationId $pendingNotificationId
     * @return PendingNotification
     */
    public function findOne(PendingNotificationId $pendingNotificationId) : PendingNotification;
}