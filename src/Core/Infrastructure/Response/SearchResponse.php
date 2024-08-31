<?php

namespace App\Core\Infrastructure\Response;

use Symfony\Component\HttpFoundation\Request;

class SearchResponse
{
    public static function create(
        Request       $request,
        \App\Core\Application\Query\SearchResponse $queryResponse
    ): array
    {
        $page = (int) $request->query->get('page') > 0 ? (int) $request->query->get('page') : 1;
        $size = (int) $request->query->get('size') > 0 ? (int) $request->query->get('size') : 12;
        $lastPage = ($page && $size) ? ceil($queryResponse->getTotal()/$size) : 1;

        $response = $queryResponse->getResult();
        $response['page'] = $page;
        $response['lastPage'] = $lastPage;
        $response['itemsPerPage'] = $size;
        $response['orderBy'] = $request->query->get('orderBy') ?? null;
        $response['orderDirection'] = $request->query->get('orderDir') ?? null;
        return $response;
    }

}