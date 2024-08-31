<?php

namespace Apps\Api\src\Controller\PendingNotifications;

use App\Core\Infrastructure\Request\SearchRequest;
use App\Core\Infrastructure\Response\SearchResponse;
use App\Notification\Application\SearchPendingNotifications\SearchPendingNotificationsQuery;
use Apps\Api\src\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchPendingNotificationsController extends BaseController
{
    public function __invoke(Request $request) : JsonResponse
    {
        $pendingNotificationsResponse = $this->ask(
            new SearchPendingNotificationsQuery(
                ...SearchRequest::create($request)
            )
        );

        return new JsonResponse(
            SearchResponse::create($request, $pendingNotificationsResponse),
            Response::HTTP_OK
        );
    }
}