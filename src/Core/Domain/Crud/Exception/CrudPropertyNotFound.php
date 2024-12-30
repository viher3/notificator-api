<?php

namespace App\Core\Domain\Crud\Exception;

use App\Core\Domain\DomainError;

final class CrudPropertyNotFound extends DomainError
{
    public function __construct(
        public readonly string $entity,
        public readonly string $value
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
        return 'Crud entity "' . $this->entity . '" property does not exists: ' . $this->value;
    }

    public function errorTranslationKey(): string
    {
        return 'crud.entity.property_not_found';
    }
}