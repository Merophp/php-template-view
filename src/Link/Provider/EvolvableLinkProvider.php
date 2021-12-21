<?php
namespace Merophp\PhpTemplateViewPlugin\Link\Provider;

use Psr\Link\EvolvableLinkProviderInterface;
use Psr\Link\LinkInterface;

/**
 * @author Robert Becker
 */
class EvolvableLinkProvider extends LinkProvider implements EvolvableLinkProviderInterface
{

    /**
     * @param LinkInterface $link
     * @return EvolvableLinkProvider
     */
    public function withLink(LinkInterface $link)
    {
        $clone = clone $this;
        $clone->links[] = $link;
        return $clone;
    }

    /**
     * @param LinkInterface $link
     * @return EvolvableLinkProvider
     */
    public function withoutLink(LinkInterface $link)
    {
        $clone = clone $this;
        unset($clone->links[array_search($link, $clone->links)]);
        return $clone;
    }
}
