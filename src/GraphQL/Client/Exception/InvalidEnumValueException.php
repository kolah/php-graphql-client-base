<?php

namespace Kolah\GraphQL\Client\Exception;

class InvalidEnumValueException extends \RuntimeException
{
    public static function forValue(string $enumValue, string $className)
    {
        return new static(sprintf('Invalid value "%s" for %s', $enumValue, $className));
    }
}
