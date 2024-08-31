<?php

namespace App\Notification\Application\SendPendingNotification;

use App\Core\Domain\Bus\Command\CommandHandler;
use App\Core\Domain\Bus\Event\EventBus;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\Exception\NotFoundPendingNotification;
use App\Notification\Domain\PendingNotification;
use App\Notification\Domain\Repository\PendingNotificationRepository;
use App\Notification\Domain\Service\PendingNotification\SendPendingNotification;
use App\Notification\Domain\ValueObject\PendingNotificationId;

class SendPendingNotificationHandler implements CommandHandler
{
    public function __construct(
        private SendPendingNotification $sendPendingNotification,
        private PendingNotificationRepository $pendingNotificationRepository,
        private EventBus $eventBus
    )
    {
    }

    /**
     * @param SendPendingNotificationCommand $command
     * @return SendPendingNotificationResponse
     * @throws \Exception
     */
    public function __invoke(SendPendingNotificationCommand $command) : SendPendingNotificationResponse
    {
        /** @var PendingNotification $pendingNotification */
        $pendingNotification = $this->pendingNotificationRepository->findOne(
            new PendingNotificationId($command->pendingNotificationId)
        );

        if(!$pendingNotification){
            throw new NotFoundPendingNotification();
        }

        $this->sendPendingNotification->execute(
            pendingNotification: $pendingNotification,
            currentTime: DomainClock::fromString($command->currentTime)
        );

        $this->pendingNotificationRepository->save($pendingNotification);
        $this->eventBus->publish(...$pendingNotification->pullDomainEvents());

        return new SendPendingNotificationResponse();
    }
}