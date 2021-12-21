<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin;

/**
 * @author Robert Becker
 */
class PhpTemplateViewConfiguration
{

    /**
     * @var string
     */
    protected string $viewDir = '';

    /**
     * @var string
     */
    protected string $resourcePostfix = '';

    /**
     * @var string
     */
    protected string $contentType = 'text/html;charset=utf-8';

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
    }

    /**
     * @param string $viewDir
     */
    public function setViewDir(string $viewDir)
    {
        $this->viewDir = $viewDir;
    }

    /**
     * @return string
     */
    public function getViewDir(): string
    {
        return $this->viewDir;
    }

    /**
     * @param string $resourcePostfix
     */
    public function setResourcePostfix(string $resourcePostfix)
    {
        $this->resourcePostfix = $resourcePostfix;
    }

    /**
     * @return string
     */
    public function getResourcePostfix(): string
    {
        return $this->resourcePostfix;
    }
}
