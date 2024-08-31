<?php

namespace App\Notification\Infrastructure\Persistence\Doctrine\Repository;

use App\Core\Domain\Filter\FilterCollection;
use App\Core\Infrastructure\Filter\ApiFilterCollection;
use App\Core\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\Core\Infrastructure\Persistence\Doctrine\Services\Search\QueryBuilderSearch;
use App\Notification\Domain\PendingNotification;
use App\Notification\Domain\Repository\PendingNotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DoctrinePendingNotificationRepository extends DoctrineRepository implements PendingNotificationRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ManagerRegistry        $registry
    )
    {
        parent::__construct(PendingNotification::class, $entityManager, $registry);
    }

    /**
     * @param PendingNotification $pendingNotification
     * @return void
     */
    public function save(PendingNotification $pendingNotification) : void
    {
        $this->persist($pendingNotification);
    }

    /**
     * @param ApiFilterCollection $filters
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
        ?string $orderDirection = null): array
    {
        $qb = $this->createQueryBuilder('n');

        $qbSearchService = new QueryBuilderSearch();
        $qbSearchService->searchQueryBuilder(
            qb: $qb,
            filters: $filters,
            page: $page,
            perPage: $perPage,
            orderBy: $orderBy,
            orderDirection: $orderDirection
        );

        // TODO: handle filters

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ApiFilterCollection $filters
     * @return int
     */
    public function searchCount(FilterCollection $filters) : int
    {
        $qbSearchService = new QueryBuilderSearch();

        return $qbSearchService->searchCount(
            qb: $this->createQueryBuilder('n'),
            filters: $filters
        );
    }
}