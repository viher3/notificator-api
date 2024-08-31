<?php

namespace Apps\Api\src\Controller;

use App\Core\Domain\Bus\Command\Command;
use App\Core\Domain\Bus\Command\CommandBus;
use App\Core\Domain\Bus\Command\CommandResponse;
use App\Core\Domain\Bus\Query\Query;
use App\Core\Domain\Bus\Query\QueryBus;
use App\Core\Domain\Bus\Query\QueryResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus   $queryBus
    )
    {
    }

    public function ask(Query $query): QueryResponse
    {
        return $this->queryBus->__invoke($query);
    }

    public function dispatch(Command $command): CommandResponse
    {
        return $this->commandBus->__invoke($command);
    }
}