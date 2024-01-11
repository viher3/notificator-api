<?php

namespace App\Notification\Domain;

abstract class Notification
{
    private array $to;

    public function __construct(
        array|string $to,
        private string $from,
        private string $message,
        private string $subject = '',
        private array $options = []
    )
    {
        $this->to = !is_array($to) ? [$to] : $to;
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
}
