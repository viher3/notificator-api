<?php

namespace App\Core\Infrastructure\Request;

use App\Core\Infrastructure\Filter\DoctrineFilterCollection;
use Symfony\Component\HttpFoundation\Request;

class SearchRequest
{
    public static function create(Request $request) : array
    {
        // TODO: create filters translator

        $data = [
            'filters' => new DoctrineFilterCollection([]),
            'page' => $request->query->get('page') ?? 1,
            'itemsPerPage' => $request->query->get('size') ?? 12,
            'orderBy' => $request->query->get('orderBy') ?? null,
            'orderDirection' => $request->query->get('orderDir') ?? null,
        ];

        return $data;
    }
}