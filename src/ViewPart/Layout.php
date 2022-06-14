<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin\ViewPart;

use Merophp\PhpTemplateViewPlugin\TemplateArgument\Argument;

class Layout extends AbstractViewPart
{

    /**
     * @param string $package
     * @param string $name
     * @param Argument[] $arguments
     */
	public function __construct(string $package, string $name, array $arguments = []){
		$this->type = 'layout';
        parent::__construct($package, $name, $arguments);
	}

}
