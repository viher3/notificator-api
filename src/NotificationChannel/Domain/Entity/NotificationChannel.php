<?php

namespace App\NotificationChannel\Domain\Entity;

use App\Core\Domain\Aggregate\AggregateRoot;
use App\Core\Domain\Time\Clock;

class NotificationChannel extends AggregateRoot
{
    private Clock $updatedAt;

    public function __construct(
        private string $id,
        private string $provider,
        private Clock $createdAt,
        private array $configuration,
        private bool $enabled = true
    )
    {
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