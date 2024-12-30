<?php

namespace App\Core\Domain\Crud\Service;

use App\Core\Domain\Crud\CrudEntity;
use App\Core\Domain\Crud\CrudFieldCollection;
use App\Core\Domain\Crud\CrudRepository;
use App\Core\Domain\Crud\Exception\CrudEntityNotFound;

final class RemoveCrudService
{
    public function execute(
        string $entityId,
        CrudRepository $crudRepository
    ) : void
    {
        /** @var CrudEntity $crudEntity */
        $crudEntity = $crudRepository->getById($entityId);

        if(!$crudEntity){
            throw new CrudEntityNotFound($crudRepository->getEntityName());
        }

        $crudRepository->remove($crudEntity);
    }
}