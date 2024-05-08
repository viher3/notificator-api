<?php

namespace App\Notificator\Application\SendSingleEmail;

use App\Core\Application\Command\CommandHandler;
use App\Notification\Domain\EmailNotification;
use App\Notificator\Domain\Service\SendSingleEmailNotificator;

final class SendSingleEmailHandler implements CommandHandler
{
    public function __construct(
        private SendSingleEmailNotificator $sendSingleEmailNotificator
    )
    {
    }

    public function execute(SendSingleEmailCommand $command) : void
    {
        $this->sendSingleEmailNotificator->send(
            new EmailNotification(
                to: $command->recipients,
                from: $command->from,
                message: $command->message,
                subject: $command->subject
            )
        );
    }
}
