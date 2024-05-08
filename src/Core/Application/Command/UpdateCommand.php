<?php

namespace App\Core\Application\Command;

readonly class UpdateCommand implements Command
{
    public function __construct(
        public string $id,
        public string $updatedAtYyyyMmDd,
        public array  $fields
    )
    {
    }
}