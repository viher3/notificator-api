<?php

namespace App\Notification\Domain\Entity;

use App\Core\Domain\Aggregate\AggregateRoot;
use App\Core\Domain\Time\Clock;
use App\Core\Domain\Time\DomainClock;
use App\Notification\Domain\Event\NotificationSent;
use App\Notification\Domain\Factory\NotificationDto;
use App\Notification\Domain\Factory\NotificationFactory;
use App\Notification\Domain\Service\Notificator\Notificator;
use App\Notification\Domain\ValueObject\NotificationId;
use App\Notification\Domain\ValueObject\PendingNotificationId;

class PendingNotification extends AggregateRoot
{
    private string $id;

    public function __construct(
        PendingNotificationId    $id,
        private readonly string  $type,
        private readonly string  $to,
        private readonly string  $from,
        private readonly string  $message,
        private readonly Clock   $createdAt,
        private ?Clock  $sentAt = null,
        private readonly ?string $subject = null,
        private readonly ?string $options = null,
    )
    {
        $this->id = $id->value();
    }

    public static function fromNotification(Notification $notification): self
    {
        return new self(
            id: PendingNotificationId::random(),
            type: $notification->getType(),
            to: implode(",", $notification->getTo()),
            from: $notification->getFrom(),
            message: $notification->getMessage(),
            createdAt: $notification->getCreatedAt(),
            subject: $notification->getSubject(),
            options: $notification->getOptions() ? json_encode($notification->getOptions()) : null
        );
    }

    /**
     * @param Notificator $notificator
     * @param NotificationFactory $notificationFactory
     * @param Clock $currentTime
     * @throws \Exception
     */
    public function send(
        Notificator $notificator,
        NotificationFactory $notificationFactory,
        Clock $currentTime
    ) : void
    {
        try{
            // Create Notification
            $to = str_contains($this->to, ',') ? explode(",", $this->to) : [$this->to];

            $notification = $notificationFactory->create(
                new NotificationDto(
                    type: $this->type,
                    to: $to,
                    from: $this->from,
                    message: $this->message,
                    createdAt: DomainClock::fromString($this->createdAt),
                    subject: $this->subject,
                    isSendConfirmationRequired: false
                )
            );

            $notificator->send($notification);
            $this->sentAt = $currentTime;

            $this->record(new NotificationSent(
                aggregateId: NotificationId::random(),
                notification: $notification,
                occurredOn: $this->createdAt->toDateTimeString()
            ));
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTo(): string
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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function getCreatedAt(): Clock
    {
        return $this->createdAt;
    }

    public function getSentAt(): ?Clock
    {
        return $this->sentAt;
    }

    public function getType(): string
    {
        return $this->type;
    }
}