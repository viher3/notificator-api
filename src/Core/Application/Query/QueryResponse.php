<?php

declare(strict_types=1);

namespace App\Core\Application\Query;

interface QueryResponse
{
    public function getResult(): array;
}