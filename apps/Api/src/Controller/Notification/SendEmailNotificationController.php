<?php

namespace Apps\Api\src\Controller\Notification;

use App\Notification\Domain\EmailNotification;
use App\Notificator\Application\Email\EmailNotificator;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendEmailNotificationController extends AbstractController
{
    public function __construct(
        private EmailNotificator $emailNotificator
    )
    {
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $body = json_decode($request->getContent(), true);

        try{
            $to = $body['to'] ?? null;
            $from = $body['from'] ?? null;
            $message = $body['message'] ?? null;
            $subject = $body['subject'] ?? '';

            Assertion::notEmpty($to, '"to" field is not specified.');
            Assertion::notEmpty($from, '"from" field is not specified.');
            Assertion::notEmpty($message, '"message" field is not specified.');

            $this->emailNotificator->send(
                new EmailNotification($to, $from, $message, $subject)
            );

            return new JsonResponse([], Response::HTTP_OK);
        }catch (AssertionFailedException $e){
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }catch (\Exception $e){
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
