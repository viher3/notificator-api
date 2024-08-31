<?php

namespace App\Core\Domain\Filter;

class DomainFilter implements Filter
{
    private mixed $handler;

    public function __construct(
        private string $field,
        private string  $value,
        private string $operator
    )
    {
        if (!in_array($this->operator, FilterOperator::AVAILABLES)) {
            throw new InvalidFilterOperator($this->operator, $this->field);
        }
    }

    public static function fromArray(array $filter) : self
    {
        return new self(
            field: $filter['field'],
            value: $filter['value'],
            operator: $filter['operator']
        );
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function serialize(): array
    {
        return [
            'field' => $this->field,
            'value' => $this->value,
            'operator' => $this->operator
        ];
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
}