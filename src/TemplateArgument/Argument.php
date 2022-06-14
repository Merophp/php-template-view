<?php

namespace Merophp\PhpTemplateViewPlugin\TemplateArgument;

class Argument
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}