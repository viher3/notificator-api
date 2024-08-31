<?php

namespace App\Core\Infrastructure\Bus\Query;

use App\Core\Domain\Bus\Query\Query;
use App\Core\Domain\Bus\Query\QueryBus;
use App\Core\Domain\Bus\Query\QueryResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyQueryBus implements QueryBus
{
    public function __construct(private MessageBusInterface $queryBus)
    {
    }

    /**
     * @param Query $query
     * @return QueryResponse
     */
    public function __invoke(Query $query): QueryResponse
    {
        $envelope = $this->queryBus->dispatch($query);

        return $envelope->last(HandledStamp::class)->getResult();
    }
}