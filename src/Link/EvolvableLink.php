<?php
namespace Merophp\PhpTemplateViewPlugin\Link;

use Psr\Link\EvolvableLinkInterface;

/**
 * @author Robert Becker
 */
class EvolvableLink extends Link implements EvolvableLinkInterface
{

    private string $href;

    private array $rels;

    private array $attributes = [];

    /**
     * @inhired
     */
    public function withHref($href)
    {
        $clone = clone $this;
        $clone->href = $href;
        return $clone;
    }

    /**
     * @inhired
     */
    public function withRel($rel)
    {
        $clone = clone $this;
        $clone->rels[] = $rel;
        return $clone;
    }

    /**
     * @inhired
     */
    public function withoutRel($rel)
    {
        $clone = clone $this;
        unset($clone->rels[array_search($rel, $clone->rels)]);
        return $clone;
    }

    /**
     * @inhired
     */
    public function withAttribute($attribute, $value)
    {
        $clone = clone $this;
        $clone->attributes[$attribute] = $value;
        return $clone;
    }

    /**
     * @inhired
     */
    public function withoutAttribute($attribute)
    {
        $clone = clone $this;
        unset($clone->attributes[$attribute]);
        return $clone;
    }
}
