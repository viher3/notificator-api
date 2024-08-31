<?php

namespace Apps\Api\src\Controller\PendingNotifications;

use App\Core\Infrastructure\Time\SystemClock;
use App\Notification\Application\SendPendingNotification\SendPendingNotificationCommand;
use App\Notification\Domain\Exception\NotFoundPendingNotification;
use Apps\Api\src\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SendPendingNotificationController extends BaseController
{
    public function __invoke(string $id) : JsonResponse
    {
        try{
            $this->dispatch(
                new SendPendingNotificationCommand(
                    pendingNotificationId: $id,
                    currentTime: (new SystemClock())->__toString()
                )
            );

            return new JsonResponse([], Response::HTTP_OK);
        }catch (NotFoundPendingNotification $e){
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }catch (\Exception $e){
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}