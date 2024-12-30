<?php

namespace App\Core\Domain\Crud;

use App\Core\Domain\Aggregate\AggregateRoot;
use App\Core\Domain\Repository\SearchRepository;

interface CrudRepository extends SearchRepository
{
    public function getById(string $id): AggregateRoot;

    public function persist(AggregateRoot $entity): void;

    public function remove(AggregateRoot $entity): void;

    public function getEntityName() : string;
}