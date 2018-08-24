<?php

namespace Kolah\GraphQL\Client;

class Collection implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @var array
     */
    protected $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    public function offsetSet($key, $value)
    {
        $this->items[$key] = $value;

        return $this;
    }

    public function offsetExists($key): bool
    {
        if (isset($this->items[$key])) {
            return true;
        }

        return false;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function getFirst()
    {
        if ($this->count() === 0) {
            return null;
        }

        return reset($this->items);
    }

    public function getLast()
    {
        if ($this->count() === 0) {
            return null;
        }

        return end($this->items);
    }

    public function count()
    {
        return count($this->items);
    }

    public function append($element): Collection
    {
        $this->items[] = $element;

        return $this;
    }

    public function map(callable $callback): Collection
    {
        $filtered = array_map($callback, $this->items);

        return new Collection($filtered);
    }

    public function filter(callable $callback): Collection
    {
        $filtered = array_filter($this->items, $callback);

        return new Collection($filtered);
    }

    public function offsetUnset($offset)
    {
        return;
    }
}
