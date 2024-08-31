<?php

namespace App\Core\Domain\Filter;

use Ramsey\Collection\AbstractCollection;

final class DomainFilterCollection extends AbstractCollection implements FilterCollection
{
    /**
     * @param array $filters
     * @return self
     */
    public static function fromArray(array $filters): self
    {
        $apiFilters = [];

        foreach ($filters as $filter) {
            $apiFilters[] = new DomainFilter(
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
     * @param string $field
     * @return DomainFilter|null
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
     * @return array
     */
    public function serialize(): array
    {
        $response = [];

        /** @var Filter $apiFilter */
        foreach ($this->data as $apiFilter) {
            $response[] = $apiFilter->serialize();
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return DomainFilter::class;
    }
}