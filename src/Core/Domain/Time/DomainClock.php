<?php

namespace App\Core\Domain\Time;

use App\Core\Domain\ValueObject\DateValueObject;

class DomainClock extends DateValueObject implements Clock
{
    public const DEFAULT_TIMEZONE = 'Europe/Madrid';

    /**
     * @param \DateTimeInterface $value
     */
    public function __construct(
        \DateTimeInterface $value
    )
    {
        $value->setTimezone(new \DateTimeZone(self::DEFAULT_TIMEZONE));
        parent::__construct($value);
    }

    /**
     * @param string $value
     * @param string $format
     * @param string $dateTime
     * @return self
     * @throws \Exception
     */
    public static function fromString(
        string $value,
        string $format = DateValueObject::DATETIME_DEFAULT_FORMAT,
        string $dateTime = 'Europe/Madrid'
    ): self
    {
        return new self(
            \DateTimeImmutable::createFromFormat(
                $format,
                $value,
                new \DateTimeZone($dateTime)
            )
        );
    }

    /**
     * @return \DateTimeInterface
     * @throws \Exception
     */
    public function currentTime(): \DateTimeInterface
    {
        return self::fromString('1991-09-01 00:00:00')->value();
    }
}
