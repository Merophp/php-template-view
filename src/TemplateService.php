<?php
declare(strict_types=1);

namespace Merophp\PhpTemplateViewPlugin;

use Exception;
use Merophp\PhpTemplateViewPlugin\TemplateArgument\Argument;

/**
 * Proxy class for PhpTemplateView to pass down for templates, layouts and partials
 * @author Robert Becker
 */
class TemplateService
{

	/**
	 * @var PhpTemplateView
	 */
	protected PhpTemplateView $view;

    /**
     * @param PhpTemplateView $view
     */
	public function __construct(PhpTemplateView $view)
    {
		$this->view = $view;
	}

    /**
     * @param string $identifier
     * @param array $argumentsAsMap
     * @return string
     */
	public function partial(string $identifier, array $argumentsAsMap = [])
    {
        return $this->view->renderPartial(
            $identifier,
            $this,
            array_map(function($key, $value){
                return new Argument($key, $value);
            }, array_keys($argumentsAsMap), array_values($argumentsAsMap))
        );
	}

    /**
     * @param string $src
     * @param array $options
     */
	public function includeBottomJsFile(string $src, array $options = [])
    {
        $this->view->includeJsFile($src, $options, 'bottom');
    }

    /**
     * @return string
     */
    public function renderIncludedBottomJsFiles(): string
    {
        return $this->view->renderIncludedJsFiles('bottom');
    }

    /**
     * @param string $methodName
     * @param array $methodArguments
     * @return false|mixed|void
     */
    public function __call(string $methodName, array $methodArguments = [])
    {
        if(!in_array($methodName, [
            'includeJsFile',
            'renderIncludedJsFiles',
            'includeCssFile',
            'renderIncludedCssFiles'
        ])) return;

        return call_user_func_array([$this->view, $methodName], $methodArguments);
    }
}
