<?php

namespace App\Notification\Domain;

use Ramsey\Collection\AbstractCollection;
use App\Core\Domain\Bus\Event\DomainEvent;
use App\Notification\Domain\Service\Notificator\SendNotificationStrategy;

class NotificationCollection extends AbstractCollection
{
    /** @var DomainEvent[] $domainEvents */
    private array $domainEvents = [];

    /** @var array<int, string>  */
    private array $errors = [];

    /** @var int $totalSubmittedSuccessfully */
    private int $totalSubmittedSuccessfully = 0;

    /**
     * @param SendNotificationStrategy $sendNotificationStrategy
     * @param int $millisecondsDelayBetweenNotifications
     */
    public function send(
        SendNotificationStrategy $sendNotificationStrategy,
        int $millisecondsDelayBetweenNotifications = 0
    ) : void
    {
        /** @var Notification $notification */
        foreach($this->data as $notification){
            try{
                $notification = $sendNotificationStrategy->execute($notification);
                $this->domainEvents = array_merge($notification->pullDomainEvents(), $this->domainEvents);
                $this->totalSubmittedSuccessfully++;

                if($millisecondsDelayBetweenNotifications){
                    sleep($millisecondsDelayBetweenNotifications);
                }
            }catch (\Exception $e){
                $this->errors[] = [
                    'notification' => $notification->serialize(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ];
            }
        }
    }

    public function getType(): string
    {
        return Notification::class;
    }

    public function getDomainEvents(): array
    {
        return $this->domainEvents;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getTotalSubmittedSuccessfully(): int
    {
        return $this->totalSubmittedSuccessfully;
    }
}