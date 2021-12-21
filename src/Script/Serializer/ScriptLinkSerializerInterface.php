<?php
namespace Merophp\PhpTemplateViewPlugin\Script\Serializer;

use Merophp\PhpTemplateViewPlugin\Script\ScriptLinkInterface;

interface ScriptLinkSerializerInterface
{
    public function serialize(ScriptLinkInterface $link): string;
}
