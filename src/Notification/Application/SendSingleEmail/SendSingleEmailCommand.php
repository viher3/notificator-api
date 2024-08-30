<?php

namespace App\Notification\Application\SendSingleEmail;

use App\Core\Application\Command\Command;

readonly class SendSingleEmailCommand implements Command
{
    public function __construct(
        public string $from,
        public string $message,
        public array|string $recipients,
        public string $createdAt,
        public ?string $subject = null,
    )
    {
    }
}
