<?php

namespace Kolah\GraphQL\Client\Exception;

class GraphQLErrorException extends \RuntimeException
{
    /** @var array */
    private $errors;

    /** @var array|null */
    private $data;

    public function __construct(array $errors, array $data = null, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $this->errors = $errors;
        $this->data = $data;

        parent::__construct($message, $code, $previous);
    }

    public static function withErrors(array $errors, array $data = null)
    {
        return new static($errors, $data);
    }
}
