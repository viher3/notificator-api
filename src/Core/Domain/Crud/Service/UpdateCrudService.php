<?php

namespace App\Core\Domain\Crud\Service;

use App\Core\Domain\Crud\CrudEntity;
use App\Core\Domain\Crud\CrudFieldCollection;
use App\Core\Domain\Crud\CrudRepository;
use App\Core\Domain\Crud\Exception\CrudEntityNotFound;

final class UpdateCrudService
{
    public function execute(
        string $entityId,
        CrudFieldCollection $fields,
        CrudRepository $crudRepository
    ) : void
    {
        /** @var CrudEntity $crudEntity */
        $crudEntity = $crudRepository->getById($entityId);

        if(!$crudEntity){
            throw new CrudEntityNotFound($crudRepository->getEntityName());
        }

        $crudEntity->partialUpdate($fields);

        $crudRepository->persist($crudEntity);
    }
}