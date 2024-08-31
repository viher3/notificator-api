<?php

namespace App\Notification\Application\SendSingleEmail;

use App\Core\Application\Command\CommandHandler;
use App\Core\Domain\Bus\Event\EventBus;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\EmailNotification;
use App\Notification\Domain\Service\Email\SendSingleEmailNotificator;
use App\Notification\Domain\Service\PendingNotification\CreatePendingNotification;

final class SendSingleEmailHandler implements CommandHandler
{
    public function __construct(
        private SendSingleEmailNotificator $sendSingleEmailNotificator,
        private EventBus $eventBus,
        private CreatePendingNotification $createPendingNotification
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function execute(SendSingleEmailCommand $command) : void
    {
        $notification = new EmailNotification(
            to: $command->recipients,
            from: $command->from,
            message: $command->message,
            createdAt: DomainClock::fromString($command->createdAt),
            subject: $command->subject,
            isSendConfirmationRequired: $command->isSendConfirmationRequired
        );

        if(!$command->isSendConfirmationRequired){
            // Send notification
            $notification->send($this->sendSingleEmailNotificator);
        }else{
            // Save notification as pending status
            $this->createPendingNotification->execute($notification);
        }

        $this->eventBus->publish(...$notification->pullDomainEvents());
    }
}
