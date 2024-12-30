<?php

namespace App\Notification\Infrastructure\Persistence\Doctrine\Repository;

use App\Core\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\Notification\Domain\Entity\NotificationLog;
use App\Notification\Domain\Repository\NotificationLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineNotificationLogRepository extends DoctrineRepository implements NotificationLogRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ManagerRegistry        $registry
    )
    {
        parent::__construct(NotificationLog::class, $entityManager, $registry);
    }

    public function save(NotificationLog $notificationLog) : void
    {
        $this->persist($notificationLog);
    }
}