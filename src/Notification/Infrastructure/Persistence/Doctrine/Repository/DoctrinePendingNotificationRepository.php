<?php

namespace App\Notification\Infrastructure\Persistence\Doctrine\Repository;

use App\Core\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\Notification\Domain\PendingNotification;
use App\Notification\Domain\Repository\NotificationPendingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DoctrinePendingNotificationRepository extends DoctrineRepository implements NotificationPendingRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ManagerRegistry        $registry
    )
    {
        parent::__construct(PendingNotification::class, $entityManager, $registry);
    }

    public function save(PendingNotification $pendingNotification) : void
    {
        $this->persist($pendingNotification);
    }
}