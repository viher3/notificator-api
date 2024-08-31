<?php

namespace Apps\Api\src\Controller\Notification;

use App\Core\Infrastructure\Time\SystemClock;
use App\Notification\Application\SendNotification\SendNotificationCommand;
use App\Notification\Application\SendNotification\SendNotificationHandler;
use App\Notification\Domain\Enum\NotificationType;
use Assert\Assert;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendNotificationController extends AbstractController
{
    public function __construct(
        private SendNotificationHandler $sendNotificatorHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);

        try {
            $type = $body['type'] ?? null;
            $to = $body['to'] ?? null;
            $from = $body['from'] ?? null;
            $message = $body['message'] ?? null;
            $subject = $body['subject'] ?? '';
            $isSendConfirmationRequired = $body['isSendConfirmationRequired'] ?? false;

            $notificationTypes = array_map(fn(NotificationType $type) => $type->value, NotificationType::cases());

            Assert::lazy()
                ->that($type)
                    ->notEmpty('"type" field is not specified.')
                    ->inArray($notificationTypes, 'Invalid "type" value.')
                ->that($to)
                    ->notEmpty('"to" field is not specified.')
                    ->isArray('"to" field must be an array')
                ->that($from)->notEmpty('"from" field is not specified.')
                ->that($message)->notEmpty('"message" field is not specified.')
                ->verifyNow();

            $this->sendNotificatorHandler->execute(
                new SendNotificationCommand(
                    type: $type,
                    from: $from,
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
