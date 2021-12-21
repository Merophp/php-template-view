<?php
namespace Merophp\PhpTemplateViewPlugin\Link\Serializer;

use Psr\Link\LinkInterface;

interface LinkSerializerInterface{
    public function serialize(LinkInterface $link): string;
}
