<?php

namespace App\Notification\Domain;

use App\Core\Domain\Aggregate\AggregateRoot;
use App\Core\Domain\Time\Clock;
use App\Notification\Domain\Event\NotificationCreated;
use App\Notification\Domain\ValueObject\NotificationId;
use Ramsey\Uuid\Uuid;

abstract class Notification extends AggregateRoot
{
    private array $to;

    public function __construct(
        array|string $to,
        private string $from,
        private string $message,
        private Clock $createdAt,
        private string $subject = '',
        private array $options = []
    )
    {
        $this->to = !is_array($to) ? [$to] : $to;

        $this->record(new NotificationCreated(
            aggregateId: NotificationId::random(),
            notification: $this,
            occurredOn: $this->createdAt->toDateTimeString()
        ));
    }

    public function getTo(): array
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

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getCreatedAt(): Clock
    {
        return $this->createdAt;
    }
}
