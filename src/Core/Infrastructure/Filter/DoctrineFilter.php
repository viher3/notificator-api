<?php

namespace App\Core\Infrastructure\Filter;

use App\Core\Domain\Filter\Filter;
use App\Core\Domain\Filter\FilterOperator;

class DoctrineFilter implements Filter
{
    private mixed $handler;
    private ?string $queryAlias = null;

    public function __construct(
        private string $field,
        private mixed  $value,
        private string $operator,
    )
    {
        if (!in_array($this->operator, FilterOperator::AVAILABLES)) {
            throw new \InvalidArgumentException(
                'Invalid filter operator "' . $this->operator . '" for field "' . $this->field . '".'
            );
        }
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    public function setHandler(mixed $handler): void
    {
        $this->handler = $handler;
    }

    public function handle(mixed $query): mixed
    {
        $handler = $this->handler;
        return $handler($query);
    }

    public function serialize(): array
    {
        return [
            'field' => $this->field,
            'value' => $this->value,
            'operator' => $this->operator
        ];
    }

    public function setQueryAlias(string $alias): void
    {
        $this->queryAlias = $alias;
    }

    public function getQueryAlias(): ?string
    {
        return $this->queryAlias;
    }
}