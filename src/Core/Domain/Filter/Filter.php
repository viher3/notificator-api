<?php

namespace App\Core\Domain\Filter;

interface Filter
{
    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     */
    public function __construct(
        string $field,
        string $value,
        string $operator
    );

    /**
     * @return string
     */
    public function getField(): string;

    /**
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * @return string
     */
    public function getOperator(): string;

    /**
     * @param mixed $handler
     * @return void
     */
    public function setHandler(mixed $handler): void;

    /**
     * @param mixed $query
     * @return mixed
     */
    public function handle(mixed $query): mixed;

    /**
     * @return array
     */
    public function serialize(): array;
}
