<?php

namespace Apps\Api\src\Controller\Notification;

use App\Core\Infrastructure\Time\SystemClock;
use App\Notification\Application\SendBatchNotifications\SendBatchNotificationsCommand;
use App\Notification\Application\SendBatchNotifications\SendBatchNotificationsHandler;
use App\Notification\Domain\Enum\NotificationType;
use Apps\Api\src\Controller\BaseController;
use Assert\Assert;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendBatchNotificationsController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true) ?? [];

        $notificationTypes = array_map(fn(NotificationType $type) => $type->value, NotificationType::cases());

        try {
            Assert::lazy()
                ->that($body)
                ->that($body)->notEmpty('Empty body')
                ->that($body)->isArray('Body is not an array')
                ->that($body)->minCount(1, 'At least one notification is required')
                ->that($body)->all()->keyExists('type', 'Required "type" property not found.')
                ->that($body)->all()->satisfy(function($item) use ($notificationTypes){
                    return in_array($item['type'], $notificationTypes);
                }, 'Invalid "type" value for notification.')
                ->that($body)->all()->keyExists('to', 'Required "to" property not found.')->isArray('"to" field must be an array')
                ->that($body)->all()->keyExists('from', 'Required "from" property not found.')
                ->that($body)->all()->keyExists('message', 'Required "message" property not found.')
                ->that($body)->all()->keyExists('isSendConfirmationRequired', 'Required "isSendConfirmationRequired" property not found.')
                ->verifyNow();

            $response = $this->dispatch(
                new SendBatchNotificationsCommand(
                    notifications: $body,
                    createdAt: (new SystemClock())->__toString()
                )
            );

            return new JsonResponse($response->getResult(), Response::HTTP_OK);
        } catch (AssertionFailedException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
