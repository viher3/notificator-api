<?php

namespace App\Core\Domain\Time;

interface Clock
{
    /**
     * @return \DateTimeInterface
     */
    public function currentTime(): \DateTimeInterface;

    /**
     * @return \DateTimeInterface
     */
    public function value(): \DateTimeInterface;

    /**
     * @return string
     */
    public function toDateTimeString(): string;

    /**
     * @return string
     */
    public function toDateString(): string;
}
