<?php

namespace App\Core\Domain\Crud\Application\Create;

use App\Core\Domain\Bus\Command\CommandHandler;
use App\Core\Domain\Crud\CrudFieldCollection;
use App\Core\Domain\Crud\CrudRepository;
use App\Core\Domain\Crud\Service\CreateCrudService;
use Doctrine\ORM\EntityManagerInterface;

class CreateCrudHandler implements CommandHandler
{
    public function __construct(
        private CreateCrudService $createCrudService,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function __invoke(CreatedCrudCommand $command)
    {
        /** @var CrudRepository $repository */
        $repository = $this->entityManager->getRepository($command->entityName);

        $this->createCrudService->execute(
            entityName: $command->entityName,
            fields: CrudFieldCollection::fromArray($command->fields),
            crudRepository: $repository
        );
    }
}