<?php

namespace App\Core\Domain\Crud;

final class SearchCrudResponse
{
    public function __construct(
        public readonly array $items,
        public readonly int $totalItems
    )
    {
    }
}