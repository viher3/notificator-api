<?php

namespace App\Core\Infrastructure\Time;

use App\Core\Domain\Time\Clock;
use App\Core\Domain\ValueObject\DateValueObject;
use DateTimeZone;

final class SystemClock extends DateValueObject implements Clock
{
    public const TIMEZONE = 'Europe/Madrid';

    /**
     * @param \DateTimeInterface|null $value
     * @throws \Exception
     */
    public function __construct(?\DateTimeInterface $value = null) {
        parent::__construct($value ?? $this->currentTime());
    }

    /**
     * @return \DateTimeInterface
     * @throws \Exception
     */
    public function currentTime(): \DateTimeInterface
    {
        return new \DateTimeImmutable("now", new DateTimeZone(self::TIMEZONE));
    }

    /**
     * @param string $date
     * @param string $separator
     * @return self
     * @throws \Exception
     */
    public static function createFromYYYYMMDD(string $date, string $separator = '-'): self
    {
        return new self(
            \DateTime::createFromFormat(
                'Y' . $separator . 'm' . $separator . 'd',
                $date,
                new DateTimeZone(self::TIMEZONE)
            )
        );
    }

    /**
     * @param string $date
     * @param string $separator
     * @return self
     * @throws \Exception
     */
    public static function createFromDDMMYYYY(string $date, string $separator = '/'): self
    {
        return new self(
            \DateTime::createFromFormat(
                'd' . $separator . 'm' . $separator . 'Y',
                $date,
                new DateTimeZone(self::TIMEZONE)
            )
        );
    }
}
