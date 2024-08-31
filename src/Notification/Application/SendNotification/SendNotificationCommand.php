<?php

namespace App\Notification\Application\SendNotification;

use App\Core\Domain\Bus\Command\Command;

readonly class SendNotificationCommand implements Command
{
    public function __construct(
        public string $type,
        public string $from,
        public string $message,
        public array $recipients,
        public string $createdAt,
        public ?string $subject = null,
        public bool $isSendConfirmationRequired = false
    )
    {
    }
}
