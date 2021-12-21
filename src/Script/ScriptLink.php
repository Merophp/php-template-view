<?php
namespace Merophp\PhpTemplateViewPlugin\Script;

/**
 * @author Robert Becker
 */
class ScriptLink implements ScriptLinkInterface
{
    private string $src;

    private array $attributes = [];

    private string $destination = '';

    /**
     * @param string $src
     * @param array $attributes
     */
    public function __construct(string $src, array $attributes = [], string $destination = '')
    {
        $this->src = $src;
        $this->attributes = $attributes;
        $this->destination = $destination;
    }

    /**
     * @return string
     */
    public function getSrc(): string
    {
        return $this->src;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @return bool
     */
    public function isTemplated(): bool
    {
        return filter_var($this->src, FILTER_VALIDATE_URL);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
