<?php

namespace App\Core\Infrastructure\Persistence\Doctrine\Services\Search;

use Doctrine\ORM\QueryBuilder;

class QueryBuilderPagination
{
    public function applyPagination(QueryBuilder $qb, int $page, int $perPage): QueryBuilder
    {
        $qb->setMaxResults($perPage);
        $qb->setFirstResult($perPage * ($page - 1));

        return $qb;
    }
}