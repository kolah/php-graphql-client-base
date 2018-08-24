<?php

namespace Kolah\GraphQL\Client;

class Mutation extends FieldSelection
{
    public static function withAction(string $field, ?array $arguments, FieldSelection $query): self
    {
        $instance = new static();

        return $instance->withSpecifiedField($field, $arguments, $query);
    }

    public function encode(): string
    {
        $encoded = parent::encode();

        return sprintf('mutation { %s }', $encoded);
    }
}
