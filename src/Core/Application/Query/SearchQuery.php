<?php

namespace App\Core\Application\Query;

use App\Core\Domain\Filter\FilterCollection;

abstract class SearchQuery
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_ITEMS_PER_PAGE = 10;

    /**
     * @param FilterCollection $filters
     * @param integer|null $page
     * @param integer|null $itemsPerPage
     * @param string|null $orderBy
     * @param string|null $orderDirection
     */
    public function __construct(
        protected FilterCollection $filters,
        protected ?int $page = self::DEFAULT_PAGE,
        protected ?int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE,
        protected ?string $orderBy = null,
        protected ?string $orderDirection = null
    ) {
        $this->page = $page ?: self::DEFAULT_PAGE;
        $this->itemsPerPage = $itemsPerPage ?: self::DEFAULT_ITEMS_PER_PAGE;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * @return FilterCollection
     */
    public function getFilters(): FilterCollection
    {
        return $this->filters;
    }

    /**
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @return string|null
     */
    public function getOrderDirection(): ?string
    {
        return $this->orderDirection;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return [
            $this->getFilters(),
            $this->getPage(),
            $this->getItemsPerPage(),
            $this->getOrderBy(),
            $this->getOrderDirection()
        ];
    }
}