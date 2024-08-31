<?php

namespace App\Notification\Application\SearchPendingNotifications;

use App\Core\Domain\Bus\Query\QueryHandler;
use App\Core\Domain\Bus\Query\QueryResponse;
use App\Core\Domain\Filter\DomainFilterCollection;
use App\Notification\Domain\NotificationCollection;
use App\Notification\Domain\PendingNotificationCollection;
use App\Notification\Domain\Repository\PendingNotificationRepository;

class SearchPendingNotificationsHandler implements QueryHandler
{
    public function __construct(
        private PendingNotificationRepository $pendingNotificationRepository
    )
    {
    }

    public function __invoke(SearchPendingNotificationsQuery $query) : QueryResponse
    {
        $filters = DomainFilterCollection::fromArray($query->getFilters()->toArray());

        $pendingNotifications = $this->pendingNotificationRepository->search(
            filters: $filters,
            page: $query->getPage(),
            perPage: $query->getItemsPerPage(),
            orderBy: $query->getOrderBy(),
            orderDirection: $query->getOrderDirection()
        );
        $totalPendingNotifications = $this->pendingNotificationRepository->searchCount($filters);

        // Create collection
        $pendingNotificationsCollection = new PendingNotificationCollection($pendingNotifications);

        return new SearchPendingNotificationsResponse(
            pendingNotifications: $pendingNotificationsCollection,
            totalPendingNotifications: $totalPendingNotifications
        );
    }
}