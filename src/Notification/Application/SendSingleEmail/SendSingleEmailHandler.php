<?php

namespace App\Notification\Application\SendSingleEmail;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\EmailNotification;
use App\Notification\Domain\Service\Email\SendSingleEmailNotificator;

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
                createdAt: DomainClock::fromString($command->createdAt),
                subject: $command->subject
            )
        );
    }
}
