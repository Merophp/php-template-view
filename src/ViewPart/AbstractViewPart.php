<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin\ViewPart;

use Merophp\PhpTemplateViewPlugin\TemplateArgument\Argument;

abstract class AbstractViewPart implements ViewPartInterface
{

	/**
	 * @var string
	 */
	protected string $package;

	/**
	 * @var string
	 */
	protected string $type = '';

	/**
	 * @var string
	 */
	protected string $name = '';

	/**
	 * @var array
	 */
	private array $arguments = [];

    /**
     * @param string $package
     * @param string $name
     * @param Argument[] $arguments
     */
	public function __construct(string $package, string $name, array $arguments = [])
    {
        $this->package = $package;
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * @param string $name
     */
	public function setName(string $name){
		$this->name = $name;
	}

    /**
     * @return string
     */
	public function getName(): string
    {
		return $this->name;
	}

    /**
     * @param string $package
     */
	public function setPackage(string $package){
		$this->package = $package;
	}

    /**
     * @return string
     */
	public function getPackage(): string
    {
		return $this->package;
	}

    /**
     * @return string
     */
	public function getType(): string
    {
		return $this->type;
	}

    /**
     * @return array
     */
	public function getArguments(): array
    {
		return $this->arguments;
	}

    /**
     * @param Argument[] $arguments
     */
	public function setArguments(array $arguments){
		$this->arguments = $arguments;
	}

    /**
     * @return string
     */
	public function getFilePath(): string
    {
		$pathData = explode('.', $this->getName());

		$typeUrlPart =$this->getType().'s';

		return $this->getPackage().'/'.$typeUrlPart.'/'.implode('/', $pathData).'.php';
	}
}
