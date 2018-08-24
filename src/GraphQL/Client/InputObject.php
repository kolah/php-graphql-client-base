<?php

namespace Kolah\GraphQL\Client;

abstract class InputObject
{
    use EncodeArgumentTrait;

    /**
     * @var array
     */
    protected $data;

    public function encode(): string
    {
        $result = [];
        foreach ($this->data as $key => $datum) {
            if (null === $datum) {
                continue;
            }
            $result[] = $key . ":" . $this->encodeArgumentValue($datum);
        }
        return implode(',', $result);
    }
}
