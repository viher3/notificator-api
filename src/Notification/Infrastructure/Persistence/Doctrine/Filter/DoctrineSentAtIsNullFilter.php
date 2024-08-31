<?php

namespace App\Notification\Infrastructure\Persistence\Doctrine\Filter;

use App\Core\Domain\Filter\Filter;
use App\Core\Domain\Filter\FilterOperator;
use App\Core\Infrastructure\Filter\DoctrineFilter;
use App\Notification\Domain\Filter\PendingNotification\SentAtIsNullFilter;
use Doctrine\ORM\QueryBuilder;

class DoctrineSentAtIsNullFilter implements SentAtIsNullFilter
{
    public function create(): Filter
    {
        $filter = (new DoctrineFilter(
            field: 'sentAt',
            value: '',
            operator: FilterOperator::CUSTOM_EXPRESSION,
        ));
        $filter->setHandler(function(QueryBuilder $queryBuilder){
            $alias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere($alias . '.sentAt IS NULL');
        });

        return $filter;
    }
}