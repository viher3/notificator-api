<?php

namespace App\Core\Infrastructure\Persistence\Doctrine\Services\Search;

use Doctrine\ORM\QueryBuilder;

class QueryBuilderOrder
{
    /**
     * @param QueryBuilder $qb
     * @param string $orderBy
     * @param string $orderDirection
     * @return QueryBuilder
     */
    protected function applyOrder(
        QueryBuilder $qb,
        string $orderBy,
        string $orderDirection = ''
    ): QueryBuilder {
        $orderDirection = ($orderDirection === 'desc') ? 'desc' : 'asc';
        $orderByWithAlias = $qb->getRootAliases()[0] . '.' . $orderBy;
        $qb->orderBy($orderByWithAlias, $orderDirection);
        return $qb;
    }

    /**
     * @param string $alias
     * @param QueryBuilder $qb
     * @param string $orderBy
     * @param string $orderDirection
     * @return QueryBuilder
     */
    public function applyOrderCustomAlias(
        string $alias,
        QueryBuilder $qb,
        string $orderBy,
        string $orderDirection = ''
    ): QueryBuilder {
        $orderDirection = ($orderDirection === 'desc') ? 'desc' : 'asc';
        $orderByWithAlias = $alias . '.' . $orderBy;
        $qb->orderBy($orderByWithAlias, $orderDirection);
        return $qb;
    }
}