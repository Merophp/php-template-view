<?php
namespace Merophp\PhpTemplateViewPlugin\Link;

use Psr\Link\LinkInterface;

/**
 * @author Robert Becker
 */
class Link implements LinkInterface
{

    private string $href;

    private array $rels;

    private array $attributes = [];

    /**
     * @param string $href
     * @param array $rels
     * @param array $attributes
     */
    public function __construct(string $href, array $rels, array $attributes = [])
    {
        $this->href = $href;
        $this->rels = $rels;
        $this->attributes = $attributes;
    }

    /**
     * @inhired
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @inhired
     */
    public function isTemplated()
    {
        return filter_var($this->href, FILTER_VALIDATE_URL);
    }

    /**
     * @inhired
     */
    public function getRels()
    {
        return $this->rels;
    }

    /**
     * @inhired
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
