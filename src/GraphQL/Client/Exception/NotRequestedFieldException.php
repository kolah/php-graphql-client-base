<?php

namespace Kolah\GraphQL\Client\Exception;

class NotRequestedFieldException extends \LogicException
{
    public static function create(): self
    {
        return new static('Field was not requested');
    }
}
