<?php

namespace App\Notification\Domain\Entity;

use App\Core\Domain\Aggregate\AggregateRoot;
use App\Core\Domain\Time\Clock;
use App\Notification\Domain\Event\NotificationSent;
use App\Notification\Domain\Service\Notificator\Notificator;
use App\Notification\Domain\ValueObject\NotificationId;

abstract class Notification extends AggregateRoot
{
    private array $to;

    public function __construct(
        private string $type,
        array|string $to,
        private string $from,
        private string $message,
        private Clock $createdAt,
        private string $subject = '',
        private array $options = [],
        private bool $isSendConfirmationRequired = false
    )
    {
        $this->to = !is_array($to) ? [$to] : $to;
    }

    /**
     * @throws \Exception
     */
    public function send(Notificator $notificator) : void
    {
        try{
            $notificator->send($this);

            $this->record(new NotificationSent(
                aggregateId: NotificationId::random(),
                notification: $this,
                occurredOn: $this->createdAt->toDateTimeString()
            ));
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getCreatedAt(): Clock
    {
        return $this->createdAt;
    }

    public function isSendConfirmationRequired(): bool
    {
        return $this->isSendConfirmationRequired;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function serialize() : array
    {
        return [
            'type' => $this->type,
            'to' => $this->to,
            'from' => $this->from,
            'subject' => $this->subject,
            'message' => $this->message,
            'options' => $this->options,
            'createdAt' => $this->createdAt,
            'isSendConfirmationRequired' => $this->isSendConfirmationRequired,
        ];
    }
}
