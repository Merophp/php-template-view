<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin\ViewPart;

class Partial extends AbstractViewPart
{

    /**
     * @param string $package
     * @param string $name
     * @param array $variables
     */
	public function __construct(string $package, string $name, array $variables = []){
		$this->type = 'partial';
        parent::__construct($package, $name, $variables);
	}
}
