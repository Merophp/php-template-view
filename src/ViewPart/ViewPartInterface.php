<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin\ViewPart;

interface ViewPartInterface
{

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $package
     */
    public function setPackage(string $package);

    /**
     * @return string
     */
    public function getPackage(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return array
     */
    public function getArguments(): array;

    /**
     * @param $arguments
     */
    public function setArguments(array $arguments);

    /**
     * @return string
     */
    public function getFilePath(): string;
}
