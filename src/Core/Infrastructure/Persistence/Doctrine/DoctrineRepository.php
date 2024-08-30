<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Persistence\Doctrine;

use App\Core\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class DoctrineRepository extends ServiceEntityRepository
{
    private $entityManager;

    /**
     * @param string $entityClass
     * @param EntityManagerInterface $entityManager
     * @param ManagerRegistry $registry
     */
    public function __construct(
        private string $entityClass,
        EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    ) {
        $this->entityManager = $entityManager;
        parent::__construct($registry, $entityClass);
    }

    /**
     * @return EntityManagerInterface
     */
    public function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @param AggregateRoot $entity
     * @return void
     */
    public function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();
    }

    /**
     * @param AggregateRoot $entity
     * @return void
     */
    public function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    /**
     * @return EntityRepository
     */
    public function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository($this->entityClass);
    }
}