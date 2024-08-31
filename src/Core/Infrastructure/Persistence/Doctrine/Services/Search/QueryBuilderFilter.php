<?php

namespace App\Core\Infrastructure\Persistence\Doctrine\Services\Search;

use App\Core\Domain\Filter\FilterOperator;
use App\Core\Infrastructure\Filter\ApiFilter;
use Doctrine\ORM\QueryBuilder;

class QueryBuilderFilter
{
    public function applyFilter(
        QueryBuilder $qb,
        ApiFilter $filter,
        string $filterAlias
    ): QueryBuilder {
        $field = $filter->getField();
        $operator = $filter->getOperator();
        $value = $filter->getValue();
        $fieldWithAlias = $filterAlias . '.' . $field;
        $fieldParamName = $field . random_int(1, 99);

        match ($operator) {
            FilterOperator::LIKE => $qb->andWhere($fieldWithAlias . ' LIKE :' . $fieldParamName)->setParameter($fieldParamName, "%" . $value . "%"),
            FilterOperator::EQUALS => $qb->andWhere($fieldWithAlias . ' = :' . $fieldParamName)->setParameter($fieldParamName, $value),
            FilterOperator::GREATER_THAN => $qb->andWhere($fieldWithAlias . ' >= :' . $fieldParamName)->setParameter($fieldParamName, $value),
            FilterOperator::LESS_THAN => $qb->andWhere($fieldWithAlias . ' <= :' . $fieldParamName)->setParameter($fieldParamName, $value),
            FilterOperator::IN => $qb->andWhere($fieldWithAlias . ' IN ( :' . $fieldParamName . ')')->setParameter($fieldParamName, $value),
            FilterOperator::NULL =>  $qb->andWhere($fieldWithAlias . ' IS NULL'),
            FilterOperator::NOT_NULL =>  $qb->andWhere($fieldWithAlias . ' IS NOT NULL'),
            default => $qb
        };

        return $qb;
    }
}