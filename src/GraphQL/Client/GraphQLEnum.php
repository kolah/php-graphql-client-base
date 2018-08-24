<?php

namespace Kolah\GraphQL\Client;

use Kolah\GraphQL\Client\Exception\InvalidEnumValueException;

abstract class GraphQLEnum
{
    /** @var string */
    protected $value;

    abstract public static function getOptions(): array;


    protected function __construct(string $value)
    {
        if (false === in_array($value, static::getOptions())) {
            throw InvalidEnumValueException::forValue($value, static::class);
        }

        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new static($value);
    }

    public function __toString()
    {
        return $this->value;
    }

    public function get(): string
    {
        return $this->value;
    }
}
