<?php

namespace App\Notification\Domain\Event;

use App\Core\Domain\Bus\Event\DomainEvent;
use App\Notification\Domain\Notification;
use App\Notification\Domain\TextNotification;

class NotificationCreated extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly Notification $notification,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct(
            aggregateId: $aggregateId,
            occurredOn: $occurredOn,
            eventId: $eventId
        );
    }

    public static function eventName(): string
    {
        return 'notification.created';
    }

    public function toPrimitives(): array
    {
        return [
            'to' => $this->notification->getTo(),
            'from' => $this->notification->getFrom(),
            'message' => $this->notification->getMessage(),
            'subject' => $this->notification->getSubject(),
            'options' => $this->notification->getOptions(),
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        string $eventId,
        string $occurredOn,
        array $body = []
    ): DomainEvent
    {
        return new self(
            aggregateId: $aggregateId,
            notification: new TextNotification(
                to: $body['to'],
                from: $body['from'],
                message: $body['message'],
                subject: $body['subject'],
                options: $body['options'],
            ),
            eventId: $eventId,
            occurredOn: $occurredOn
        );
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }
}