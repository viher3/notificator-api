<?php

namespace App\Core\Infrastructure\Bus\Event;

use App\Core\Domain\Bus\Event\DomainEvent;
use App\Core\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyEventBus implements EventBus
{
    /**
     * @param MessageBusInterface $eventBus
     */
    public function __construct(
        private MessageBusInterface $eventBus
    ) {
    }

    /**
     * @param DomainEvent ...$events
     * @return void
     */
    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
