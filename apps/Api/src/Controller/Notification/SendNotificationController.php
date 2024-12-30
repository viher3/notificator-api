<?php

namespace Apps\Api\src\Controller\Notification;

use App\Core\Infrastructure\Time\SystemClock;
use App\Notification\Application\SendNotification\SendNotificationCommand;
use Apps\Api\src\Controller\BaseController;
use Assert\Assert;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendNotificationController extends BaseController
{
    public function __invoke(string $notificationChannelId, Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);

        try {
            $to = $body['to'] ?? [];
            $message = $body['message'] ?? null;
            $subject = $body['subject'] ?? '';
            $isSendConfirmationRequired = $body['isSendConfirmationRequired'] ?? false;

            // TODO: move field validation to NotificationFactory class.
            Assert::lazy()
                ->that($notificationChannelId)
                    ->notEmpty('"notificationChannelId" field is not specified.')
                ->that($message)->notEmpty('"message" field is not specified.')
                ->verifyNow();

            $this->dispatch(
                new SendNotificationCommand(
                    notificationChannelId: $notificationChannelId,
                    message: $message,
                    recipients: $to,
                    createdAt: (new SystemClock())->__toString(),
                    subject: $subject,
                    isSendConfirmationRequired: $isSendConfirmationRequired
                )
            );

            return new JsonResponse([], Response::HTTP_OK);
        } catch (AssertionFailedException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
