<?php
namespace Merophp\PhpTemplateViewPlugin\Script\Collection;

use IteratorAggregate;
use ArrayIterator;
use Merophp\PhpTemplateViewPlugin\Script\ScriptLinkInterface;

/**
 * @author Robert Becker
 */
class ScriptLinkCollection implements IteratorAggregate
{

    /**
     * @var array
     */
    protected array $links = [];

    /**
     * @param ScriptLinkInterface $link
     */
    public function add(ScriptLinkInterface $link)
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
     * @param ScriptLinkInterface $link
     * @return bool
     */
    public function has(ScriptLinkInterface $link): bool
    {
        return in_array($link, $this->links);
    }

    /**
     * @param ScriptLinkInterface $link
     */
    public function remove(ScriptLinkInterface $link)
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
     * @param string $destination
     * @return iterable
     */
    public function getScriptLinksByDestination(string $destination = ''): iterable
    {
        foreach($this->links as $link){
            if($link->getDestination() == $destination) yield $link;
        }
    }

    /**
     * @return iterable
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->links);
    }
}
