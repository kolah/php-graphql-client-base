<?php

namespace Kolah\GraphQL\Client;

use PhpOption\None;
use PhpOption\Some;

abstract class OutputObject
{
    /**
     * @param array  $fields
     * @param string $key
     */
    protected function scalarFromArray(array $fields, $key)
    {
        if (!array_key_exists($key, $fields)) {
            $this->$key = None::create();
        } else {
            $this->$key = Some::create($fields[$key]);
        }
    }

    /**
     * @param array  $fields
     * @param string $key
     * @param string $type The name of the custom scalar class
     */
    protected function customScalarFromArray(array $fields, $key, $type)
    {
        if (!array_key_exists($key, $fields)) {
            $this->$key = None::create();
        } elseif (is_null($fields[$key])) {
            $this->$key = Some::create(null);
        } else {
            $scalar     = call_user_func([$type, 'parse'], $fields[$key]);
            $this->$key = Some::create($scalar);
        }
    }

    /**
     * @param array  $fields
     * @param string $key
     * @param string $type The name of the class this represents. It should also have a `fromArray` method
     */
    protected function instanceFromArray(array $fields, $key, $type)
    {
        if (!array_key_exists($key, $fields)) {
            $this->$key = None::create();
        } elseif (is_null($fields[$key])) {
            $this->$key = Some::create(null);
        } else {
            $parsed = call_user_func([$type, 'fromArray'], $fields[$key]);
            $this->$key = Some::create($parsed);
        }
    }

    /**
     * @param array    $fields
     * @param string   $key
     * @param \Closure $fromArray
     */
    protected function listFromArray(array $fields, $key, \Closure $fromArray)
    {
        if (!array_key_exists($key, $fields)) {
            $this->$key = None::create();
        } elseif (is_null($fields[$key])) {
            $this->$key = Some::create(null);
        } else {
            $this->$key = Some::create(new Collection(array_map($fromArray, $fields[$key])));
        }
    }

    /**
     * @param array  $fields
     * @param string $key
     * @param string $type The name of the enum class
     */
    protected function enumFromArray(array $fields, $key, $type)
    {
        if (!array_key_exists($key, $fields)) {
            $this->$key = None::create();
        } elseif (is_null($fields[$key])) {
            $this->$key = Some::create(null);
        } else {
            $enum       = call_user_func([$type, 'fromString'], $fields[$key]);
            $this->$key = Some::create($enum);
        }
    }
}
