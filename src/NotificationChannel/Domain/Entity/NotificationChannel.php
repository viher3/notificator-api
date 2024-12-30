<?php

namespace App\NotificationChannel\Domain\Entity;

use App\Core\Domain\Aggregate\AggregateRoot;
use App\Core\Domain\Time\Clock;
use App\NotificationChannel\Domain\ValueObject\Provider;

class NotificationChannel extends AggregateRoot
{
    private string $provider;
    private Clock $updatedAt;

    public function __construct(
        private string $id,
        Provider $provider,
        private Clock $createdAt,
        private array $configuration,
        private bool $enabled = true
    )
    {
        $this->provider = $provider->value();
        $this->updatedAt = $this->createdAt;
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