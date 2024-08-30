<?php

namespace App\Notification\Domain;

use App\Core\Domain\Time\Clock;
use App\Core\Domain\Aggregate\AggregateRoot;
use App\Notification\Domain\ValueObject\NotificationLogId;

class NotificationLog implements AggregateRoot
{
    private string $id;

    public function __construct(
        NotificationLogId $id,
        private readonly string  $to,
        private readonly string  $from,
        private readonly string  $message,
        private readonly ?string $subject = null,
        private readonly ?string $options = null,
        private Clock $createdAt
    )
    {
        $this->id = $id->value();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function getCreatedAt(): Clock
    {
        return $this->createdAt;
    }
}