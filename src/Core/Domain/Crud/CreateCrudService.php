<?php

namespace App\Core\Domain\Crud;

use App\Core\Domain\Aggregate\AggregateRoot;

final class CreateCrudService
{
    public function execute(
        AggregateRoot $aggregateRoot,
        CrudRepository $crudRepository
    ) : void
    {

    }
}