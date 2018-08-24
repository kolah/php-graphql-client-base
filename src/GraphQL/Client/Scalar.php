<?php

namespace Kolah\GraphQL\Client;

class Scalar implements ScalarInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public static function parse(string $value)
    {
        return new static(strval($value));
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }
}
