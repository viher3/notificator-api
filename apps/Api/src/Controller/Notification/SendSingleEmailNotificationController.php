<?php

namespace Apps\Api\src\Controller\Notification;

use App\Notificator\Application\SendSingleEmail\SendSingleEmailCommand;
use App\Notificator\Application\SendSingleEmail\SendSingleEmailHandler;
use Assert\Assert;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendSingleEmailNotificationController extends AbstractController
{
    public function __construct(
        private SendSingleEmailHandler $sendSingleEmailNotificatorHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);

        try {
            $to = $body['to'] ?? null;
            $from = $body['from'] ?? null;
            $message = $body['message'] ?? null;
            $subject = $body['subject'] ?? '';

            Assert::lazy()
                ->that($to)->notEmpty('"to" field is not specified.')
                ->that($from)->notEmpty('"from" field is not specified.')
                ->that($message)->notEmpty('"message" field is not specified.')
                ->verifyNow();

            $this->sendSingleEmailNotificatorHandler->execute(
                new SendSingleEmailCommand(
                    from: $from,
                    message: $message,
                    recipients: $to,
                    subject: $subject
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
