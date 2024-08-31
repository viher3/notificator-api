<?php

namespace App\Core\Domain\Filter;

use App\Core\Domain\DomainError;

class InvalidFilterOperator extends DomainError
{
    public function __construct(
        private string $operator,
        private string $field,
    )
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 500;
    }

    public function errorMessage(): string
    {
        return 'Invalid filter operator: "' . $this->operator . '". for field ' . $this->field;
    }

    public function errorTranslationKey(): string
    {
        return 'filter.invalid_operator';
    }
}