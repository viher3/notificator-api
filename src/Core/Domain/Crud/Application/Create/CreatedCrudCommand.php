<?php

namespace App\Core\Domain\Crud\Application\Create;

use App\Core\Domain\Bus\Command\Command;

class CreatedCrudCommand implements Command
{
    public function __construct(
        public readonly string $entityName,
        public readonly array $fields
    )
    {
    }
}