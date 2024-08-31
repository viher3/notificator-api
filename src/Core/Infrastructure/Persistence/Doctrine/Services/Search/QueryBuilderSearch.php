<?php

namespace App\Core\Infrastructure\Persistence\Doctrine\Services\Search;

use App\Core\Domain\Filter\FilterCollection;
use App\Core\Infrastructure\Filter\DoctrineFilterCollection;
use Doctrine\ORM\QueryBuilder;

class QueryBuilderSearch
{
    /**
     * @param QueryBuilder $qb
     * @param DoctrineFilterCollection $filters
     * @param int $page
     * @param int $perPage
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @return array
     */
    public function search(
        QueryBuilder $qb,
        FilterCollection $filters,
        int $page,
        int $perPage,
        ?string $orderBy = null,
        ?string $orderDirection = null
    ): array {
        $qb = $this
            ->searchQueryBuilder($qb, $filters, $page, $perPage, $orderBy, $orderDirection);
        return $qb->getQuery()->execute();
    }

    /**
     * @param QueryBuilder $qb
     * @param DoctrineFilterCollection $filters
     * @param int $page
     * @param int $perPage
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @param string|null $qbAlias
     * @return QueryBuilder
     */
    public function searchQueryBuilder(
        QueryBuilder $qb,
        FilterCollection $filters,
        int $page = 0,
        int $perPage = 0,
        ?string $orderBy = null,
        ?string $orderDirection = null,
        ?string $qbAlias = null
    ): QueryBuilder {
        $qbAlias = $qbAlias ?: 'u';

        foreach ($filters as $filter) {
            $qbFilterService = new QueryBuilderFilter();
            $qbFilterService->applyFilter($qb, $filter, $qbAlias);
        }

        if ($orderBy && $orderDirection) {
            $qbOrderService = new QueryBuilderOrder();
            $qbOrderService->applyOrderCustomAlias($qbAlias, $qb, $orderBy, $orderDirection);
        }

        if ($page && $perPage) {
            $qbPaginationService = new QueryBuilderPagination();
            $qbPaginationService->applyPagination($qb, $page, $perPage);
        }

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param DoctrineFilterCollection $filters
     * @return int
     */
    public function searchCount(
        QueryBuilder $qb,
        FilterCollection $filters,
    ): int
    {
        $qb = $this->searchQueryBuilder($qb, $filters);
        $qb->select('count(1) as total');
        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}