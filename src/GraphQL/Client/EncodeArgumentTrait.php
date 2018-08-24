<?php

namespace Kolah\GraphQL\Client;

trait EncodeArgumentTrait
{
    private function encodeArgumentValue($value): string
    {
        switch (true) {
            case is_int($value):
            case is_float($value):
                return (string)$value;

            case $value instanceof Collection:
                $valuesEncoded = $value->map(function ($value) {
                    return $this->encodeArgumentValue($value);
                });
                return sprintf("[%s]", implode(',', iterator_to_array($valuesEncoded)));
            case $value instanceof GraphQLEnum:
                // Unquoted string for enums
                return sprintf("%s", $value);
            case $value instanceof ScalarInterface:
                return sprintf('"%s"', $value->serialize());
            case $value instanceof InputObject:
                return sprintf('{%s}', $value->encode());
            default:
                return sprintf('"%s"', $value);
        }
    }
}
