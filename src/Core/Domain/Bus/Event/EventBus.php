<?php

namespace App\Core\Domain\Bus\Event;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}