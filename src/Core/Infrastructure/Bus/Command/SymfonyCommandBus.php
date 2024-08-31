<?php

namespace App\Core\Infrastructure\Bus\Command;

use App\Core\Domain\Bus\Command\Command;
use App\Core\Domain\Bus\Command\CommandBus;
use App\Core\Domain\Bus\Command\CommandResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    public function __invoke(Command $command): CommandResponse
    {
        $envelope = $this->commandBus->dispatch($command);

        return $envelope->last(HandledStamp::class)->getResult();
    }
}