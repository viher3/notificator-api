<?php

namespace App\Core\Infrastructure\Persistence\Doctrine\Type;

use App\Core\Infrastructure\Time\SystemClock;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class DoctrineSystemClock extends Type
{
    private const TYPE_NAME = 'SystemClock';

    private const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
    private const DATE_FORMAT = 'Y-m-d';

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return 'DATETIME';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return SystemClock|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?SystemClock
    {
        if (!$value) {
            return null;
        }

        if ($datetimeObject = new \DateTime($value)) {
            return new SystemClock($datetimeObject);
        }

        if ($datetimeObject = \DateTime::createFromFormat(self::DATE_TIME_FORMAT, $value)) {
            return new SystemClock($datetimeObject);
        }

        if ($dateObject = \DateTime::createFromFormat(self::DATE_FORMAT, $value)) {
            return new SystemClock($dateObject);
        }

        try {
            return new SystemClock(new \DateTime($value));
        } catch (\Exception) {
        }

        throw new \InvalidArgumentException(sprintf('Cannot convert "%s" to a new SystemClock object.', $value));
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (is_null($value)) {
            return $value;
        }

        $formatDate = $value->value()->format(self::DATE_FORMAT);
        $formatDateTime = $value->value()->format(self::DATE_TIME_FORMAT);

        return $formatDate === $formatDateTime ? $formatDate : $formatDateTime;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}
