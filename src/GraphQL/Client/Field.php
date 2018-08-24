<?php

namespace Kolah\GraphQL\Client;

class Field
{
    /** @var string */
    private $name;

    /** @var array|null */
    private $arguments;

    /** @var FieldSelection|null */
    private $selection;

    public function __construct(string $name, ?array $arguments = null, ?FieldSelection $selection = null)
    {
        $this->name      = $name;
        $this->arguments = $arguments;
        $this->selection = $selection;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    public function getSelection(): ?FieldSelection
    {
        return $this->selection;
    }
}
