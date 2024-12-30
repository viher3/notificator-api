<?php

namespace App\NotificationChannel\Domain\Entity;

use App\Core\Domain\Crud\CrudEntity;
use App\Core\Domain\Time\Clock;
use App\NotificationChannel\Domain\ValueObject\Provider;

class NotificationChannel extends CrudEntity
{
    protected string $id;
    protected string $provider;
    protected array $configuration;
    protected Clock $createdAt;
    protected Clock $updatedAt;
    protected bool $enabled = true;

    public static function create(
        string $id,
        Provider $provider,
        Clock $createdAt,
        array $configuration,
        bool $enabled = true
    ) : self
    {
        $notificationChannel = new self();
        $notificationChannel->id = $id;
        $notificationChannel->provider = $provider->value();
        $notificationChannel->configuration = $configuration;
        $notificationChannel->createdAt = $createdAt;
        $notificationChannel->updatedAt = $createdAt;
        $notificationChannel->enabled = $enabled;
        return $notificationChannel;
    }

    public function getUpdatedAt(): Clock
    {
        return $this->updatedAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getCreatedAt(): Clock
    {
        return $this->createdAt;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}