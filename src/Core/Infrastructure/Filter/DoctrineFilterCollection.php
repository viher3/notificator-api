<?php

namespace App\Core\Infrastructure\Filter;

use App\Core\Domain\Filter\Filter;
use App\Core\Domain\Filter\FilterCollection;
use Ramsey\Collection\AbstractCollection;

final class DoctrineFilterCollection extends AbstractCollection implements FilterCollection
{
    /**
     * @param array $filters
     * @return self
     */
    public static function fromArray(array $filters): self
    {
        $apiFilters = [];

        foreach ($filters as $filter) {
            $apiFilters[] = new DoctrineFilter(
                $filter['field'],
                $filter['value'],
                $filter['operator']
            );
        }

        return new self($apiFilters);
    }

    /**
     * @param string $value
     * @return self
     */
    public static function fromPrimitives(string $value)
    {
        $filters = json_decode($value, true);

        return self::fromArray($filters ?: []);
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        $response = [];

        /** @var DoctrineFilter $apiFilter */
        foreach ($this->data as $apiFilter) {
            $response[] = $apiFilter->serialize();
        }

        return $response;
    }

    /**
     * @param string $field
     * @return Filter|null
     */
    public function findByField(string $field) : ?Filter
    {
        /** @var Filter $filter */
        foreach($this->data as $filter){
            if($filter->getField() === $field){
                return $filter;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return DoctrineFilter::class;
    }
}