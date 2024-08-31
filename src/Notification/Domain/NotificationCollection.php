<?php

namespace App\Notification\Domain;

use App\Core\Domain\Bus\Event\DomainEvent;
use App\Notification\Domain\Service\Notificator\Notificator;
use Ramsey\Collection\AbstractCollection;

class NotificationCollection extends AbstractCollection
{
    /** @var DomainEvent[] $domainEvents */
    private array $domainEvents = [];

    /** @var array<int, string>  */
    private array $errors = [];

    /**
     * @param Notificator $notificator
     * @param int $millisecondsDelayBetweenNotifications
     */
    public function send(
        Notificator $notificator,
        int $millisecondsDelayBetweenNotifications = 0
    ) : void
    {
        /** @var Notification $notification */
        foreach($this->data as $notification){
            try{
                $notification->send($notificator);

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
}