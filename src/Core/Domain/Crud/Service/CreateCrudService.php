<?php

namespace App\Core\Domain\Crud\Service;

use App\Core\Domain\Crud\CrudEntity;
use App\Core\Domain\Crud\CrudFieldCollection;
use App\Core\Domain\Crud\CrudRepository;

final class CreateCrudService
{
    public function execute(
        string $entityName,
        CrudFieldCollection $fields,
        CrudRepository $crudRepository
    ) : CrudEntity
    {
        /** @var CrudEntity $crudEntity */
        $crudEntity = new $entityName();
        $crudEntity->partialUpdate($fields);

        $crudRepository->persist($crudEntity);

        return $crudEntity;
    }
}