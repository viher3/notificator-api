<?php

namespace App\Core\Domain\Crud\Service;

use App\Core\Domain\Crud\CrudRepository;
use App\Core\Domain\Crud\SearchCrudResponse;
use App\Core\Domain\Filter\FilterCollection;

final class SearchCrudService
{
    public function execute(
        CrudRepository $crudRepository,
        FilterCollection $filters,
        int $page,
        int $perPage,
        ?string $orderBy = null,
        ?string $orderDirection = null
    ) : SearchCrudResponse
    {
        $items = $crudRepository->search(
            filters: $filters,
            page: $page,
            perPage: $perPage,
            orderBy: $orderBy,
            orderDirection: $orderDirection
        );

        $total = $crudRepository->searchCount($filters);

        return new SearchCrudResponse($items, $total);
    }
}