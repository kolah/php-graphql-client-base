<?php

namespace Kolah\GraphQL\Client\Exception;

class HttpTransportException extends \RuntimeException
{
    public static function forStatusCode(int $statusCode, string $reason): self
    {
        return new static(sprintf("GraphQL HTTP transport error, status code: %s", $statusCode, $reason));
    }
}
