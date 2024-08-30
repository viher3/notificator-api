<?php

namespace App\Core\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    protected $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->ensureIsValidUuid($value);

        $this->value = $value;
    }

    /**
     * @return self
     */
    public static function random(): self
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param [type] $id
     * @return void
     */
    private function ensureIsValidUuid($id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new \InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }

    /**
     * @param Uuid $other
     * @return boolean
     */
    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }
}