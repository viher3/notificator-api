<?php

namespace App\Core\Application\Query;

use App\Core\Domain\Bus\Query\QueryResponse;

interface SearchResponse extends QueryResponse
{
    public function getTotal() : int;
}