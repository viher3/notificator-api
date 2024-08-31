<?php

namespace App\Notification\Domain;

use App\Core\Domain\Time\Clock;
use App\Core\Domain\Aggregate\AggregateRoot;
use App\Notification\Domain\ValueObject\PendingNotificationId;

class PendingNotification extends AggregateRoot
{
    private string $id;

    public function __construct(
        PendingNotificationId    $id,
        private readonly string  $to,
        private readonly string  $from,
        private readonly string  $message,
        private readonly Clock   $createdAt,
        private readonly ?Clock  $sentAt = null,
        private readonly ?string $subject = null,
        private readonly ?string $options = null,
    )
    {
        $this->id = $id->value();
    }

    public static function fromNotification(Notification $notification): self
    {
        return new self(
            id: PendingNotificationId::random(),
            to: implode(",", $notification->getTo()),
            from: $notification->getFrom(),
            message: $notification->getMessage(),
            createdAt: $notification->getCreatedAt(),
            subject: $notification->getSubject(),
            options: $notification->getOptions() ? json_encode($notification->getOptions()) : null
        );
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

    public function getSentAt(): ?Clock
    {
        return $this->sentAt;
    }
}