<?php

namespace App\Core\Domain\Crud\Exception;

use App\Core\Domain\DomainError;

final class CrudEntityNotFound extends DomainError
{
    public function __construct(
        public readonly string $entity
    )
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 404;
    }

    public function errorMessage(): string
    {
        return 'Crud entity "' . $this->entity . '" not found.';
    }

    public function errorTranslationKey(): string
    {
        return 'crud.entity.not_found';
    }
}