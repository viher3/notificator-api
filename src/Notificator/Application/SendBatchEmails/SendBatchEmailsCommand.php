<?php

namespace App\Notificator\Application\SendBatchEmails;

use App\Core\Application\Command\Command;

readonly class SendBatchEmailsCommand implements Command
{
    public function __construct(
        public array $notifications
    )
    {
    }
}
