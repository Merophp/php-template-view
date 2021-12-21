<?php
namespace Merophp\PhpTemplateViewPlugin\Link\Provider;

use Psr\Link\LinkInterface;
use Psr\Link\LinkProviderInterface;

/**
 * @author Robert Becker
 */
class LinkProvider implements LinkProviderInterface
{

    /**
     * @var array
     */
    protected array $links = [];

    /**
     * @param LinkInterface ...$links
     */
    public function __construct(LinkInterface ...$links)
    {
        $this->links = $links;
    }

    /**
     * @return iterable
     */
    public function getLinks()
    {
        yield from $this->links;
    }

    /**
     * @return iterable
     */
    public function getLinksByRel($rel)
    {
        yield from array_filter($this->links, function($link) use ($rel){
            return in_array($rel, $link->getRels());
        });
    }

    /**
     * @param LinkInterface $link
     * @return bool
     */
    public function hasLink(LinkInterface $link): bool
    {
        return in_array($link, $this->links);
    }
}
