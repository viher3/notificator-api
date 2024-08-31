<?php

namespace App\Core\Infrastructure\Response;

use App\Core\Domain\Bus\Query\QueryResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchResponse
{
    public static function create(
        Request       $request,
        QueryResponse $queryResponse
    ): array
    {
        $response = $queryResponse->getResult();
        $response['page'] = $request->query->get('page') ?? 1;
        $response['itemsPerPage'] = $request->query->get('size') ?? 12;
        $response['orderBy'] = $request->query->get('orderBy') ?? null;
        $response['orderDirection'] = $request->query->get('orderDir') ?? null;
        return $response;
    }

}