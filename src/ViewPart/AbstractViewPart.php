<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin\ViewPart;

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
	private array $localVariables = [];

    /**
     * @param string $package
     * @param string $name
     * @param array $variables
     */
	public function __construct(string $package, string $name, array $variables = [])
    {
        $this->package = $package;
        $this->name = $name;
        $this->localVariables = $variables;
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
	public function getLocalVariables(): array
    {
		return $this->localVariables;
	}

    /**
     * @param $variables
     */
	public function setLocalVariables($variables){
		$this->localVariables = $variables;
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
