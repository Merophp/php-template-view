<?php

namespace Merophp\PhpTemplateViewPlugin\Script;

interface ScriptLinkInterface
{
    public function getSrc(): string;
    public function getAttributes(): array;
    public function isTemplated(): bool;
}
