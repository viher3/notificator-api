<?php

namespace App\NotificationChannel\Domain\Repository;

use App\NotificationChannel\Domain\Entity\NotificationChannel;

interface NotificationChannelRepository
{
    public function getById(string $id) : ?NotificationChannel;

    public function findOrFail(string $id) : NotificationChannel;
}