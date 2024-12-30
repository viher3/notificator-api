<?php

namespace App\Core\Domain\Crud;

use Ramsey\Collection\AbstractCollection;

final class CrudFieldCollection extends AbstractCollection
{
    public function getType(): string
    {
        return CrudField::class;
    }
}