<?php

namespace App\Core\Domain\Crud;

final class CrudField
{
    public function __construct(
        public readonly string  $name,
        public readonly mixed   $value,
        public readonly ?string $label = null,
    )
    {
    }
}