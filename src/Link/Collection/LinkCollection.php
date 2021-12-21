<?php
namespace Merophp\PhpTemplateViewPlugin\Link\Collection;

use ArrayIterator;
use Exception;
use IteratorAggregate;
use Psr\Link\LinkInterface;
use Traversable;

/**
 * @author Robert Becker
 */
class LinkCollection implements IteratorAggregate
{

    /**
     * @var array
     */
    protected array $links = [];

    /**
     * @param LinkInterface $link
     */
    public function add(LinkInterface $link)
    {
        $this->links[] = $link;
    }

    /**
     * @param iterable $links
     */
    public function addMultiple(iterable $links)
    {
        foreach($links as $link){
            $this->add($link);
        }
    }

    /**
     * @param LinkInterface $link
     * @return bool
     */
    public function has(LinkInterface $link): bool
    {
        return in_array($link, $this->links);
    }

    /**
     * @param LinkInterface $link
     */
    public function remove(LinkInterface $link)
    {
        unset($this->links[array_search($link, $this->links)]);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !(bool)count($this->links);
    }

    /**
     * @param string $rel
     * @return iterable
     */
    public function getByRel(string $rel): iterable
    {
        yield from array_filter($this->links, function($link) use ($rel){
            return in_array($rel, $link->getRels());
        });
    }

    /**
     * @return iterable
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->links);
    }
}
