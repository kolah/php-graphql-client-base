<?php

namespace Kolah\GraphQL\Client;

interface ScalarInterface
{
    /**
     * Serialize the client format into the correct format for the server.
     */
    public function serialize(): string;

    /**
     * Parse the value returned from the server into the correct client format.
     *
     * @return mixed
     */
    public static function parse(string $value);

    /**
     * Get the value of the custom scalar
     *
     * @return mixed
     */
    public function value();
}
