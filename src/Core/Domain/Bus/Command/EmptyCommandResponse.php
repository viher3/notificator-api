<?php

declare(strict_types=1);

namespace App\Core\Domain\Bus\Command;

class EmptyCommandResponse implements CommandResponse
{
    public function getResult(): array
    {
        return [];
    }
}