<?php

namespace App\NotificationChannel\Infrastructure\Persistence\Doctrine\Repository;

use App\Core\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\NotificationChannel\Domain\Entity\NotificationChannel;
use App\NotificationChannel\Domain\Exception\NotificationChannelNotFound;
use App\NotificationChannel\Domain\Repository\NotificationChannelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineNotificationChannelRepository extends DoctrineRepository implements NotificationChannelRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ManagerRegistry        $registry
    )
    {
        parent::__construct(NotificationChannel::class, $entityManager, $registry);
    }

    public function save(NotificationChannel $notificationChannel) : void
    {
        $this->persist($notificationChannel);
    }

    public function getById(string $id): ?NotificationChannel
    {
        return $this->find($id);
    }

    public function findOrFail(string $id): NotificationChannel
    {
        $entity = $this->getById($id);

        if(!$entity){
            throw new NotificationChannelNotFound();
        }

        return $entity;
    }
}