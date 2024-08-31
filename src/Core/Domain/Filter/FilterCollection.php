<?php

namespace App\Core\Domain\Filter;

use Ramsey\Collection\CollectionInterface;

interface FilterCollection extends CollectionInterface
{
    /**
     * @param string $field
     * @return Filter|null
     */
    public function findByField(string $field) : ?Filter;
}
