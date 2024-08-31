<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Filter\FilterCollection;

interface SearchRepository
{
    public function search(
        FilterCollection $filters,
        int $page,
        int $perPage,
        ?string $orderBy = null,
        ?string $orderDirection = null
    ): array;

    public function searchCount(FilterCollection $filters): int;
}