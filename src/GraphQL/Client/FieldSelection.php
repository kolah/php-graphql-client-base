<?php

namespace Kolah\GraphQL\Client;

abstract class FieldSelection
{
    use EncodeArgumentTrait;

    /** @var Field[] */
    protected $fields;

    public function __construct(array $fields = [])
    {
        $this->fields = $fields;
    }

    /**
     * @return static
     */
    public static function create(): self
    {
        return new static();
    }

    protected function withSpecifiedField(string $field, ?array $arguments, ?FieldSelection $selection = null)
    {
        return new static(array_merge($this->fields, [new Field($field, $arguments, $selection)]));
    }

    public function encode(): string
    {
        $fields = array_map(
            function (Field $field) {
                $encodedArguments = '';
                if ($field->getArguments()) {
                    $arguments = [];
                    foreach ($field->getArguments() as $name => $value) {
                        $encodedValue = $this->encodeArgumentValue($value);
                        $arguments[] = sprintf('%s:%s', $name, $encodedValue);
                    }

                    $encodedArguments = $arguments ? sprintf('(%s)', implode(',', $arguments), '') : '';
                }

                $encodedSelection = '';
                if ($field->getSelection()) {
                    $selection = $field->getSelection()->encode();

                    if ($selection) {
                        $encodedSelection = sprintf('{%s}', $selection);
                    }
                }

                return sprintf('%s%s%s', $field->getName(), $encodedArguments, $encodedSelection);
            },
            $this->fields
        );

        return implode(',', $fields);
    }
}
