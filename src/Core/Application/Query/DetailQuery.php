<?php

declare(strict_types=1);

namespace App\Core\Application\Query;

use App\Core\Domain\Bus\Query\Query;

class DetailQuery implements Query
{
    public function __construct(
        private string $id,
    ) {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
