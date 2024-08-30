<?php

namespace App\Core\Domain\Bus\Event;

use Ramsey\Uuid\Nonstandard\Uuid;

abstract class DomainEvent
{
    protected $aggregateId;
    protected $eventId;
    protected $occurredOn;

    /**
     * @param string $aggregateId
     * @param string $occurredOn
     * @param string|null $eventId
     * @param array $body
     */
    public function __construct(
        string $aggregateId,
        string $occurredOn,
        string $eventId = null,
        protected array $body = []
    ) {
        $this->aggregateId = $aggregateId;
        $this->eventId = $eventId ?: Uuid::uuid4();
        $this->occurredOn  = $occurredOn;
    }

    /**
     * @return string
     */
    abstract public static function eventName(): string;

    /**
     * @return array
     */
    abstract public function toPrimitives(): array;

    /**
     * @param string $aggregateId
     * @param string $eventId
     * @param string $occurredOn
     * @param array $body
     * @return self
     */
    abstract public static function fromPrimitives(
        string $aggregateId,
        string $eventId,
        string $occurredOn,
        array $body = []
    ): self;

    /**
     * @return string
     */
    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    /**
     * @return string
     */
    public function eventId(): string
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }
}
