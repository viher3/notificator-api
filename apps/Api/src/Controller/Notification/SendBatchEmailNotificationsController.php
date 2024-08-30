<?php

namespace Apps\Api\src\Controller\Notification;

use App\Core\Infrastructure\Time\SystemClock;
use App\Notification\Application\SendBatchEmails\SendBatchEmailsCommand;
use App\Notification\Application\SendBatchEmails\SendBatchEmailsHandler;
use Assert\Assert;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendBatchEmailNotificationsController extends AbstractController
{
    public function __construct(
        private SendBatchEmailsHandler $sendBatchEmailsHandler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true) ?? [];

        try {
            Assert::lazy()
                ->that($body)
                ->that($body)->notEmpty('Empty body')
                ->that($body)->isArray('Body is not an array')
                ->that($body)->minCount(1, 'At least one notification is required')
                ->that($body)->all()->keyExists('to', 'Required "to" property not found.')
                ->that($body)->all()->keyExists('from', 'Required "from" property not found.')
                ->that($body)->all()->keyExists('message', 'Required "message" property not found.')
                ->verifyNow();

            $this->sendBatchEmailsHandler->execute(
                new SendBatchEmailsCommand(
                    notifications: $body,
                    createdAt: (new SystemClock())->__toString()
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
