<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin\ViewPart;

use Merophp\PhpTemplateViewPlugin\TemplateArgument\Argument;

class Partial extends AbstractViewPart
{

    /**
     * @param string $package
     * @param string $name
     * @param Argument[] $arguments
     */
	public function __construct(string $package, string $name, array $arguments = []){
		$this->type = 'partial';
        parent::__construct($package, $name, $arguments);
	}
}
